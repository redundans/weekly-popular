import app from 'flarum/admin/app';

app.initializers.add('redundans-weekly-popular-admin', () => {
  app.extensionData
    .for('redundans-weekly-popular')
    .registerSetting({
      setting: 'weekly_popular_enabled',
      label: app.translator.trans('redundans-weekly-popular.admin.enabled_label'),
      type: 'switch',
    })
    .registerSetting({
      setting: 'weekly_popular_timeframe',
      label: app.translator.trans('redundans-weekly-popular.admin.timeframe_label'),
      type: 'number',
      min: 1,
      max: 30,
      help: app.translator.trans('redundans-weekly-popular.admin.timeframe_help'),
    })
    .registerSetting({
      setting: 'weekly_popular_label',
      label: app.translator.trans('redundans-weekly-popular.admin.label_label'),
      type: 'text',
    });
});
