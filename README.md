# SyndMetricsBundle

**BUNDLE STILL UNDER HEAVY DEVELOPMENT**

SyndMetricsBundle adds easy metric tracking to your application. Its goal is to stay out of your way as much as possible, keeping your application code unaffected. Simply create a Bundle/Resources/config/metrics.yml file, containing...

    metrics:
        # Goal Name
        registration:
            funnel:
                - visit_site       # Dispatch these events
                - signup_form      #   as stuff occurs
                - signup_complete

Each funnel item represents an event name, which you call from the dispatcher. Upon running
  
    app/console synd:metrics:sync
    app/console cache:clear

the system will save your new events, listen for them, and store metric data automatically.

Planned features:
- **area to view stats, or at least fetch**
- define cohorts; groups of users, controlled by various user fields (join date, profile field x, etc.)
- AB testing (create "_a" or "_b" versions of templates to have it automatically switch and track usage.
