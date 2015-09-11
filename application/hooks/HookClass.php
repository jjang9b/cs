<?php
class HookClass
{
  public function hookPreSystem()
  {
    //echo "called pre_system";
  }

  public function hookPreController()
  {
    //echo "called pre_controller";
  }

  public function hookPostControllerConstructor()
  {
    //echo "called post_controller_constructor";

    $CI =& get_instance();

    if ('development' == ENVIRONMENT && $CI->config->item('enable_profiler'))
    {
      $CI->output->enable_profiler(TRUE);

      /*
      $arrSection['benchmarks'] = false;
      $arrSection['memory_usage'] = TRUE;
      $arrSection['config'] = TRUE;
      $arrSection['controller_info'] = TRUE;
      $arrSection['http_headers'] = TRUE;
      $arrSection['get'] = TRUE;
      $arrSection['post'] = TRUE;
      $arrSection['uri_string'] = TRUE;
      $arrSection['queries'] = TRUE;
      $arrSection['query_toggle_count'] = TRUE;

      $CI->output->set_profiler_sections($sections);
      */
    }
  }

  public function hookPostController()
  {
    //echo "called post_controller";
  }

  public function hookDisplayOverride()
  {
    //echo "called display_override";
  
    //$CI =& get_instance();
    //echo $CI->output->get_output();
  }

  public function hookCacheOverride()
  {
    //echo "called cash_override";
  }

  public function hookPostSystem()
  {
    //echo "called post_system";
  }

}
