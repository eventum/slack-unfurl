# Extensible Slack App for link unfurling

*Slack app for [unfurling] issue links*

[unfurling]: https://api.slack.com/docs/message-link-unfurling

## Slack App

[Create](https://api.slack.com/apps/new) or [Manage](https://api.slack.com/apps) your app.

You need `Verification Token` (`SLACK_VERIFICATION_TOKEN`) for next step.

Under `Features`:
- enable [Events API](http://api.slack.com/events-api) for [`link_shared`](https://api.slack.com/events/link_shared) event with `links:read` scope.
  1. Click `Event Subscriptions` on the left.
  2. Click `Enable Events`.
  3. Click `Add Workspace Event` and add `link_shared`.
  4. Click `Add Domain` and type your domain.
  5. Click `Save Changes`.
- add `links:write` permission scope
  1. Click `OAuth & Permissions` on the left.
  2. Go to `Scopes` section and select `Add link previews to messages` in the list of permissions.
  3. Click `Save Changes`.
- enable `Incoming Webhooks`

Obtain `OAuth Access Token` (`SLACK_API_TOKEN`) under `OAuth & Permissions`

## Configuration

```
cp env.example .env
```

The configuration can be managed by [symfony/flex]:

```
composer config extra.symfony.allow-contrib true
```

[symfony/flex]: https://flex.symfony.com/

## Adding providers

The app itself handles no links, you need to add some providers:

- [Eventum Provider](https://github.com/eventum/slack-unfurl-eventum)
- [GitLab Provider](https://github.com/glensc/slack-unfurl-gitlab)
- [Jira Provider](https://github.com/glensc/slack-unfurl-jira)
- [Zendesk Provider](https://github.com/rcknr/slack-unfurl-zendesk)

## Troubleshoot

If the unfurl is not happening check that the domain is not [blacklisted](https://my.slack.com/admin/attachments).

If you modify app domains, you need to `Install App` (`/install-on-team` as url) again to re-authorize.

## Development

Install composer deps and start builtin HTTP server:

```
composer install
composer run server
```

To build docker image locally and run it:

```
docker build -t slack-unfurl .
docker run --rm -p 4390:4390 -v $(pwd)/var/log:/app/var/log -v $(pwd)/.env:/app/.env slack-unfurl
```

The service is accessible from http://slack-unfurl.127.0.0.1.xip.io:4390/ or just http://localhost:4390/
