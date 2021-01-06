<?php

if (
  !function_exists('twig') &&

  // Check if Twig is installed. To use this helper, it is required to add Twig
  // as a Composer dependency. Please see the README file for more info.
  file_exists(VENDORPATH . 'twig')
) {
  $twig = null;

  /**
   * Helper function for rendering Twig views.
   * (The default templates folder is APPPATH . 'Views')
   *
   * @param string $view View path
   * @param array $data Data to be passed to the view
   * @return string View rendered as string
   */
  function twig(string $view, array $data = []): string {
    global $twig;

    if ($twig === null) {
      $loader = new \Twig\Loader\FilesystemLoader(APPPATH . 'Views');

      $config = [];
      if (strtolower(getenv('CI_ENVIRONMENT')) === 'production')
        $config = ['cache' => WRITEPATH . '/cache/twig'];
      $twig = new \Twig\Environment($loader, $config);
    }

    return $twig->load($view)->render($data);
  }
}
