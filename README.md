# Mautic Custom Unsubscribe for Mautic 

Allow use any landing page to build custom unsubscribe page with manage channels and segments.
First you need linked it in footer with special email token {custom_unsubscribe_page=landing-page-alias}
Then you can customize that landing page with custom tokens bellow.

## Installation

### Manual

1. Use last version
2. Unzip files to plugins/MauticCustomUnsubscribeBundle
3. Clear cache (app/cache/prod/)
4. Go to /s/plugins/reload

## Usage

### 1. Insert link to email footer

Use token {custom_unsubscribe_page=landing-page-alias} to put custom unsubscribe link to landing  page.

### 2. Design Landing page

You can use any landing page to build custom unsubscribe page with new tokens:

#### For any email type:

- {custom_unsubscribe_segment=alias-of-segment} - subscribe/unsubscribe link to any segment
- {custom_unsubscribe_channel=channel} - subscribe/unsubscribe link to any channel (email, sms)


#### For segment (broadast email) email/campaign email

- {custom_unsubscribe} - subscribe/unsubscribe link to segment where broadcast email were sent or campaign email was sent (source of campaign)
- {custom_unsubscribe_segment_name} - segment name

## Example: 

<img src="https://user-images.githubusercontent.com/462477/70915651-815fd000-201a-11ea-8c92-f639e1da8f5d.gif" width="500"> 

## More Mautic stuff

- Plugins from Mautic Extendee Family  https://mtcextendee.com/plugins
- Mautic themes https://mtcextendee.com/themes

### Credits

<div>Icons made by <a href="https://www.flaticon.com/authors/freepik" title="Freepik">Freepik</a>