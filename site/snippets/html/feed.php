<?=
  page('actualites')
    ->children()
    ->listed()
    ->flip()
    ->limit(10)
    ->feed(['title' => site()->title()]);
