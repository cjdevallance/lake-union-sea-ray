# plugin-core

This plugin is intended to be installed and activated in all websites.
It has a set of core libraries that will be used by theme and other DMM plugins as well. This plugin is required by several plugins. The following resources will be used from this plugin:
- Global Wordpress options (eg. party ID of customer)
- API and Helper classes

# Setup

- Activate Plugin
- Go to settings and populate all required fields
- You are done!

# What is available in this plugin?

- MMP API
- Mailer
- PDF Generator

## MMP API

An interface has been implemented which allows querying for any page from MMP Services which in turn call Search API.
This interface class allows pulling results for any page for any OEM Party ID. It allows configuring number of results per page, sort order, and more. This class is intended to be used in theme templates which are going to be handling the presentation layer manufacturer showrooms.

Usage:

$api = new Mmp_API();<br />
$api->set_party_id($party_id);<br />
$api->set_current_page(1);       // if not specified, 1st page is returned<br />
$api->set_fields('DocumentID');  // optional<br />
$api->set_results_per_page(20);  // optional<br />
$api->set_sort_by('DocumentID'); // optional<br />
$results = $api->ger_results();<br />
