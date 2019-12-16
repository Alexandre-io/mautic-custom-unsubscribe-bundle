# Mautic Custom Unsubscribe for Mautic 

## Installation

### Manual

1. Use last version
2. Unzip files to plugins/MauticCustomUnsubscribeBundle
3. Clear cache (app/cache/prod/)
4. Go to /s/plugins/reload

## Usage

### Landing page

You can use any landing page to build custom unsubscribe page with new tokens:

#### For all emails:

- {custom_unsubscribe_segment=alias-of-segment} - subscribe/unsubscribe link to any segment
- {custom_unsubscribe_channel=channel} - subscribe/unsubscribe link to any channel (email, sms)


#### For segment (broadast email) email

- {custom_unsubscribe_broadcast} - subscribe/unsubscribe link to segment where broadcast email were sent 
- {custom_unsubscribe_broadcast_segment_name} - segment name

## Email

Use token {custom_unsubscribe_page=landing-page-alias} to put unsubscribe page to email footer.

## Example: 

<img src="https://user-images.githubusercontent.com/462477/70915651-815fd000-201a-11ea-8c92-f639e1da8f5d.gif" width="500"> 

## More Mautic stuff

- Plugins from Mautic Extendee Family  https://mtcextendee.com/plugins
- Mautic themes https://mtcextendee.com/themes

### Credits

<div>Icons made by <a href="https://www.flaticon.com/authors/freepik" title="Freepik">Freepik</a>