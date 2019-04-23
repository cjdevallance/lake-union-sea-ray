<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-config.php');

    global $wpdb;

    $table_name = $wpdb->prefix . 'inventory';

    //$sql = $wpdb->prepare ( "SELECT * FROM %s",$table_name );

    //$table_result = $wpdb->get_results( $sql , ARRAY_A );

    $table_result = $wpdb->get_results( "SELECT * FROM $table_name" );

    // Build page HTML

        $html .= '<div class="current_displays">';
            $html .= '<div id=current_displays><h3>' . __( 'Current Inventory Displays' , 'inventory-plugin' ) . '</h3></div>';


            $html .= '<div class="inv_table">';
                $html .= '<ul>';


                    $html .= '<li class="list_id">' . __( 'Page' , 'inventory-plugin' ) . '</li>';
                    $html .= '<li class="list_cond">' . __( 'New/Used' , 'inventory-plugin' ) . '</li>';
                    $html .= '<li class="list_manu">' . __( 'Manufacturers' , 'inventory-plugin' ) . '</li>';
                    $html .= '<li class="list_view">' . __( 'View Page' , 'inventory-plugin' ) . '</li>';
                    $html .= '<li class="list_edit">' . __( 'Edit' , 'inventory-plugin' ) . '</li>';
                    $html .= '<li class="list_remove">' . __( 'Remove' , 'inventory-plugin' ) . '</li>';
                    $html .= '</ul>';
                $html .= '<div class="inv_list_area">';

                    $count_results = 0;
                    foreach ( $table_result as $result ) {
                    $count_results++;
                    $id = $result->id;
                    $condition = $result->new_used;
                    $name = $result->page;
                    $newused = $result->new_used;
                    $newused = ucwords($newused);
                        if (empty($newused)) {
                            $newused = "All";
                        }
                    $manufacturer_list = $result->manufacturers;
                    $manufacturer_list = urldecode($manufacturer_list);
                    $manufacturer_list = str_replace(",", ", ", $manufacturer_list);
                    $manufacturer_list = trim($manufacturer_list, ", ");
                    $manufacturer_list = ucwords($manufacturer_list);
                    $manufacturer_list = str_replace('"', ' ', $manufacturer_list);
                    $manufacturer_list_first = substr($manufacturer_list, 0, 80);
                    $manufacturer_list_first_last = substr($manufacturer_list, 80);
                    if($count_results % 2 != "0") {
                    $html .= '<div class="inv_res">';
                        } else {
                        $html .= '<div class="inv_res_even">';
                            }
                            $html .= '<div class="inv_block inv_id">' . $name . '</div>';
                            $html .= '<div class="inv_block inv_cond">' . $newused . '</div>';
                            $html .= '<div class="inv_block inv_manuarea">';
                            $html .= '<div class="inv_manu">' . $manufacturer_list_first . '</div>';
                            if (!empty($manufacturer_list_first_last)) {
                            $html .= '<div class="more" id="more-'.$id.'">' . __( 'View All' , 'inventory-plugin' ) . '</div>';
                            $html .= '<div class="inv_all_manu" id="inv_all_manu-'.$id.'"><div id="close_all_manu">x close</div><div id="text_all_menu">' . $manufacturer_list . '</div></div>';
                            }
                            $html .= '</div>';
                            $html .= '<div class="inv_block inv_view"><a target="_blank" href="' . get_permalink($id) . '">' . __( 'View' , 'inventory-plugin' ) . '</a></div>';
                            $html .= '<div class="inv_block inv_edit"><a href="#" class="edit_button" id="edit-'.$id.'-' . $condition . '"><div id="not_edited">' . __( 'Edit' , 'inventory-plugin' ) . '</a></div></div>';
                            $html .= '<div class="inv_block del_wrapper"><a href="#" class="del_button" id="del-'.$id.'"><div id="not_removed">X ' . __( 'Remove' , 'inventory-plugin' ) . '</a></div></div>';
                        $html .= '</div>';

                    if ( isset ( $_POST['recordToDelete'] ) ) {
                    $remove_page_id = filter_var($_POST['recordToDelete'],FILTER_SANITIZE_NUMBER_INT);
                    global $wpdb;

                    $table_name = $wpdb->prefix . 'inventory';

                    $wpdb->query ( $wpdb->prepare (
                        "
                                DELETE FROM $table_name
                                WHERE id = %d
                            ",
                            $remove_page_id
                    ) );
                    
                    delete_post_meta($remove_page_id, '_wp_page_template');

                    }

                    }
                $html .= '</div>';
            $html .= '</div>';
        $html .= '</div>';


    echo $html;

