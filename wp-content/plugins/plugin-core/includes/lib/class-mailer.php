<?php
/**
 * Mailer - Generic mailer
 *
 * @package plugin-core
 *
 * @version 1.0
 * @author Tim Hysniu
 * @link https://github.dominionenterprises.com/DMM-CW-US/plugin-core
 */

/**
 * Mailer class
 *
 */
class Mailer implements Dmm_Service {
    
    const MODAL_TYPE_DEFAULT = 1;    
    const MODAL_TYPE_REQUEST = 2;
    
    /**
     * @var string
     */
    protected $from = '';
    
    /**
     * @var string
     */
    protected $from_name = '';
    
    /**
     * @var array
     */
    protected $recipients = array();
    
    /**
     * @var string
     */
    protected $subject = '';
    
    /**
     * @var string
     */
    protected $content = '';
    
    /**
     * @var array
     */
    protected $headers = array();
    
    function __construct() {
    }
    
    /**
     * Add recipient 
     * @param string $email_address
     */
    public function add_to($email_address)
    {
        $this->recipients[] = $email_address;
    }
    
    /**
     * @param string $from_email
     * @param string $from_name
     */
    public function set_from($from_email, $from_name = '')
    {
        $this->from = $from_email;
        $this->from_name = $from_name;
    }    
    
    /**
     * @param string $subject
     */
    public function set_subject($subject)
    {
        $this->subject = $subject;
    }
    
    public function set_content($content) {
        $this->content = $content;
    }
    
    /**
     * 
     * @param boolean $is_html
     */
    public function set_html($is_html = false) {
        if($is_html) {
            $this->headers[] = 'Content-Type: text/html; charset=UTF-8';
        }
    }
    
    public function get_processed_subject($email_type)
    {
        switch($email_type) {
            case self::MODAL_TYPE_REQUEST:
                $subject = __('Request Information');
            default:
                $subject = __('Contact Us');
        }
        
        return $subject;
    }
    
    public function get_processed_content($data)
    {
        $template = locate_template($data['mail-template'] . '.php');
        if(empty($template)) {
            $template = locate_template('mail-contact-us.php');
        }
        
        $contents = file_get_contents($template);
        $request_keys = array_keys($data);
        $search = array();
        $replace = array();
        foreach($request_keys as $key) {
            array_push($search, '[' . $key . ']');
            array_push($replace, esc_html($data[$key]));
        }
        
        $contents = str_replace($search, $replace, $contents);
        
        return $contents;
    }

    /**
     * Get rendered contact form modal html.
     * modal-template has to exist in your templates or default will be used.
     * 
     * @param int $modal_type
     */
    public static function get_contact_form($modal_type = 1)
    {
        switch($modal_type) {
            case self::MODAL_TYPE_REQUEST:
                $contact_form_config = array(
                    'title'          => __('Request More Information'),
                    'mail-template'  => 'mail-request-info',
                    'modal-template' => 'modal-contact-form',
                    'mail-type'     => $modal_type
                );
                break;
            default:
                $contact_form_config = array(
                    'title'          => __('Contact Us'),
                    'mail-template'  => 'mail-contact-us',
                    'modal-template' => 'modal-contact-form',
                    'mail-type'     => $modal_type
                );
        }
        
        include(locate_template($contact_form_config['modal-template'] . '.php'));
    }    
    
    /**
     * Send contact message
     *
     * @return multitype:boolean
     */
    public static function do_request($config = array())
    {
        $mailer = new Mailer();
        $admin_email = get_option('admin_email');
        $content = $mailer->get_processed_content($_REQUEST);
        $subject = $mailer->get_processed_subject($_REQUEST['mail-type']);
    
        $mailer->add_to($admin_email);
        $mailer->set_from($admin_email, get_option('blogname'));
        $mailer->set_subject($subject);
        $mailer->set_content($content);
        $mailer->set_html(true);
        $sent = $mailer->deliver_email();
    
        $title = $sent ? __('Success') : __('Error');
        $message =  $sent ?
        __('Your message has been sent successfully.', 'plugin-core') :
        __('There was a problem while sending your message. Please try again later.', 'plugin-core');
    
        return array(
                'success' => $sent,
                'title' => $title,
                'message' => $message
        );
    }    
    
    /**
     * Send email to all recipients
     */
    protected function deliver_email()
    {
        $sent = true;
        foreach($this->recipients as $recipient) {
            $sent = $sent && wp_mail( $recipient, $this->subject, $this->content, $this->headers );
        }
    
        return $sent;
    }    
    
}