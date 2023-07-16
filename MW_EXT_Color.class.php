<?php

namespace MediaWiki\Extension\PkgStore;

use MWException;
use OutputPage, Parser, PPFrame, Skin;

/**
 * Class MW_EXT_Color
 */
class MW_EXT_Color
{
  /**
   * Register tag function.
   *
   * @param Parser $parser
   *
   * @return void
   * @throws MWException
   */
  public static function onParserFirstCallInit(Parser $parser): void
  {
    $parser->setHook('color', [__CLASS__, 'onRenderTag']);
  }

  /**
   * Render tag function.
   *
   * @param $input
   * @param array $args
   * @param Parser $parser
   * @param PPFrame $frame
   *
   * @return string
   */
  public static function onRenderTag($input, array $args, Parser $parser, PPFrame $frame): string
  {
    // Argument: type.
    $getType = MW_EXT_Kernel::outClear($args['type'] ?? '' ?: '');
    $outType = empty($getType) ? '' : ' style="color:' . $getType . ';"';

    // Get content.
    $getContent = trim($input);
    $outContent = $parser->recursiveTagParse($getContent, $frame);

    // Out parser.
    return '<span' . $outType . ' class="mw-color">' . $outContent . '</span>';
  }

  /**
   * Load resource function.
   *
   * @param OutputPage $out
   * @param Skin $skin
   *
   * @return void
   */
  public static function onBeforePageDisplay(OutputPage $out, Skin $skin): void
  {
    $out->addModuleStyles(['ext.mw.color.styles']);
  }
}
