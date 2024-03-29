# CraByFy Universal plugin for Craft CMS 3.x

Based on the [CraByFy plugin](https://github.com/Dunckelfeld/craft_crabyfy), 
CraByFy Universal can be used to simply 
trigger a gitlab pipeline hook for preview and live deployment 
via craft cms backend.

![Screenshot](resources/img/crabyfy.png)

## Requirements

This plugin requires Craft CMS 3.0.0 or later.

## Installation

1. Installation via composer:

        composer require Dunckelfeld/cra-by-fy-universal

2. In the Control Panel, go to Settings → Plugins and click the 
“Install” button for CraByFy Universal.

## Configuring CraByFy

Visit `/admin/settings/plugins/cra-by-fy-universal` and set up urls, hooks to trigger pipelines.

## Using CraByFy

Visit `/admin/actions/cra-by-fy-universal/deploy` to deploy to staging or production.

Brought to you by [Dunckelfeld](dunckelfeld.de) 🤓