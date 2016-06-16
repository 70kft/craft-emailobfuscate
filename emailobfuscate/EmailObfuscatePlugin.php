<?php
namespace Craft;

class EmailObfuscatePlugin extends BasePlugin
{
  public function getName()
  {
    return Craft::t('EmailObfuscate');
  }

  public function getVersion()
  {
    return '0.1.0';
  }

  public function getDeveloper()
  {
    return 'Jeremy Williams';
  }

  public function getDeveloperUrl()
  {
    return 'http://70kft.com/';
  }

  public function hasCpSection()
  {
    return false;
  }

  public function addTwigExtension()
  {
    Craft::import('plugins.emailobfuscate.twigextensions.EmailObfuscateTwigExtension');

    return new EmailObfuscateTwigExtension();
  }
}