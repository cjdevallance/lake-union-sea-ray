# plugin-oem-showrooms

This plugin is responsible for:
1) Importing customer supported brands from provisioning
2) Handling the presentation layer for manufacturer showrooms using MMP/Search API

## Requirements 

To use this plugin you need to activate and configure core plugin. Classes from this plugins are used but there also options from core plugin that will be used. Options required from core plugin are:
- MMP API Key
- Provisioning REST API Service URL
- Client Party ID

If you are unsure about these options it's okay. If you go to 'Settings' of showrooms plugin you will see if there are options missing.

Core plugin can can be found here: 
https://github.dominionenterprises.com/DMM-CW/plugin-core

## Setup

- Make sure core plugin is activated
- Activate showrooms plugin
- Go to settings to configure plugin. You can save with default options. Make sure that in settings page you are not seeing any missing core plugin settings.
- Save settings
- Run the import. This will be done automatically at next scheduled interval but run it anyway.

## Import process

Importing of brands and OEM listings is done upon activation of this plugin. When the plugin is activated it will schedule a recurring import job which will run weekly by default. Frequency of imports can be configured in OEM Showrooms Settings.

There are two integration points with this plugin: Provision REST API and MMP Service. These are used to pull supported brands and OEM listings, rrespectively.

### Supported brands imports

Supported brands are pulled from IMT and stored, json encoded, as an option in Wordpress under option name: oem_showrooms_brands

### Presentation Layer for OEM Listings

This includes 
- New Boat Showrooms Landing page. This is where the brands are shown and can be homepage
- Showrooms brand page. This is where all models for the specified brands are listed.
- Showrooms details page. This is the details showing pictures, description and specs of selected model
