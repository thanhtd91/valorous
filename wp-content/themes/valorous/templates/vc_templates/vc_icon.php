<?php
/** @var $this WPBakeryShortCode_VC_Icon */
$icon = $color = $size = $align = $el_class = $custom_color = $link = $background_style = $background_color = $type = $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypoicons = $icon_linecons = '';

$defaults = array(
    'type' => 'fontawesome',
    'icon_fontawesome' => 'fa fa-adjust',
    'icon_openiconic' => '',
    'icon_typicons' => '',
    'icon_entypoicons' => '',
    'icon_linecons' => '',
    'icon_entypo' => '',
    'color' => '',
    'custom_color' => '',
    'background_style' => '',
    'background_color' => '',
    'custom_background' => '',
    'size' => 'md',
    'align' => 'center',
    'el_class' => '',
    'link' => '',
    'css_animation' => ''
);

if(isset($atts['addon'])){
    $defaults['icon_fontawesome'] = '';
}


/** @var array $atts - shortcode attributes */
$atts = vc_shortcode_attribute_parse( $defaults, $atts );
extract( $atts );


if(

    ($type == 'fontawesome' && !$icon_fontawesome) ||
    ($type == 'openiconic' && !$icon_openiconic) ||
    ($type == 'typicons' && !$icon_typicons) ||
    ($type == 'linecons' && !$icon_linecons) ||
    ($type == 'entypo' && !$icon_entypo)
){
    return;
}


$class = $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );
$css_class .= $this->getCSSAnimation( $css_animation );
// Enqueue needed icon font.
vc_icon_element_fonts_enqueue( $type );


$uniqid = 'vc_icon_element_'.uniqid();
$styles = array();
$custom_css = $styles_html = '';

if($background_color == 'custom' && $custom_background && $background_style){
    $styles[] = "background-color: ".$custom_background;
}
if($background_style == 'hexagonal'){
    $custom_css .= '#'.$uniqid.'.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-size-xl.vc_icon_element-have-style-inner.vc_icon_element-style-hexagonal:before{border-bottom-color: '.$custom_background.';}';
    $custom_css .= '#'.$uniqid.'.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-size-xl.vc_icon_element-have-style-inner.vc_icon_element-style-hexagonal:after{border-top-color: '.$custom_background.';}';

}


$url = vc_build_link( $link );
$has_style = false;
if ( strlen( $background_style ) > 0 ) {
    $has_style = true;
    if ( strpos( $background_style, 'outline' ) !== false ) {
        $background_style .= ' vc_icon_element-outline'; // if we use outline style it is border in css
    } else {
        $background_style .= ' vc_icon_element-background';
    }
}
$iconClass = isset( ${"icon_" . $type} ) ? esc_attr( ${"icon_" . $type} ) : 'fa fa-adjust';


if(count($styles)){
    $styles_html = 'style="'.implode(';', $styles).'"';
}





if($custom_css){
    $custom_css = '<div class="kt_custom_css">'.$custom_css.'</div>';
}

?>
<div
  id="<?php echo $uniqid; ?>"  class="vc_icon_element vc_icon_element-outer<?php echo esc_attr( $css_class ); ?>  vc_icon_element-align-<?php echo esc_attr( $align ); ?> <?php if ( $has_style ): echo 'vc_icon_element-have-style'; endif; ?>">
    <div
      <?php echo $styles_html; ?>  class="vc_icon_element-inner vc_icon_element-color-<?php echo esc_attr( $color ); ?> <?php if ( $has_style ): echo 'vc_icon_element-have-style-inner'; endif; ?> vc_icon_element-size-<?php echo esc_attr( $size ); ?>  vc_icon_element-style-<?php echo esc_attr( $background_style ); ?> vc_icon_element-background-color-<?php echo esc_attr( $background_color ); ?>"><span
            class="vc_icon_element-icon <?php echo $iconClass; ?>" <?php echo( $color === 'custom' ? 'style="color:' . esc_attr( $custom_color ) . ' !important"' : '' ); ?>></span><?php
        if ( strlen( $link ) > 0 && strlen( $url['url'] ) > 0 ) {
            echo '<a class="vc_icon_element-link" href="' . esc_attr( $url['url'] ) . '" title="' . esc_attr( $url['title'] ) . '" target="' . ( strlen( $url['target'] ) > 0 ? esc_attr( $url['target'] ) : '_self' ) . '"></a>';
        }
        ?></div>
</div>
<?php echo $custom_css; ?>

<?php echo $this->endBlockComment( '.vc_icon_element' ); ?>
