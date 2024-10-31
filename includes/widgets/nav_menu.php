<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use ElementorPro\Plugin;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

if( !class_exists("OSF_Elementor_Nav_menu_Widget") ) {

    class OS1F_Elementor_Nav_menu_Widget extends Widget_Base {

        protected $nav_menu_index = 1;

        public function get_name() {
            return 'opal-nav-menu';
        }

        public function get_title() {
            return __('Opal Nav Menu', 'opalmegamenu');
        }

        public function get_icon() {
            return 'eicon-nav-menu';
        }

        public function get_categories() {
            return ['opal-addons'];
        }

        public function on_export($element) {
            unset($element['settings']['menu']);

            return $element;
        }

        protected function get_nav_menu_index() {
            return $this->nav_menu_index++;
        }

        private function get_available_menus() {
            $menus = wp_get_nav_menus();

            $options = [];

            foreach ($menus as $menu) {
                $options[$menu->slug] = $menu->name;
            }

            return $options;
        }

        protected function register_controls() {

            $this->start_controls_section(
                'section_layout',
                [
                    'label' => __('Layout', 'opalmegamenu'),
                ]
            );

            $menus = $this->get_available_menus();

            if (!empty($menus)) {
                $this->add_control(
                    'menu',
                    [
                        'label'        => __('Menu', 'opalmegamenu'),
                        'type'         => Controls_Manager::SELECT,
                        'options'      => $menus,
                        'default'      => array_keys($menus)[0],
                        'save_default' => true,
                        'separator'    => 'after',
                        'description'  => sprintf(__('Go to the <a href="%s" target="_blank">Menus screen</a> to manage your menus.', 'opalmegamenu'), admin_url('nav-menus.php')),
                    ]
                );
            } else {
                $this->add_control(
                    'menu',
                    [
                        'type'            => Controls_Manager::RAW_HTML,
                        'raw'             => sprintf(__('<strong>There are no menus in your site.</strong><br>Go to the <a href="%s" target="_blank">Menus screen</a> to create one.', 'opalmegamenu'), admin_url('nav-menus.php?action=edit&menu=0')),
                        'separator'       => 'after',
                        'content_classes' => 'opalelementor-panel-alert opalelementor-panel-alert-info',
                    ]
                );
            }

            $this->add_control(
                'layout',
                [
                    'label'              => __('Layout', 'opalmegamenu'),
                    'type'               => Controls_Manager::SELECT,
                    'default'            => 'horizontal',
                    'options'            => [
                        'horizontal' => __('Horizontal', 'opalmegamenu'),
                        'vertical'   => __('Vertical', 'opalmegamenu'),
                        'dropdown'   => __('Dropdown', 'opalmegamenu')
                    ],
                    'frontend_available' => true,
                ]
            );

            $this->add_control(
                'align_items',
                [
                    'label'        => __('Align', 'opalmegamenu'),
                    'type'         => Controls_Manager::CHOOSE,
                    'label_block'  => false,
                    'options'      => [
                        'left'    => [
                            'title' => __('Left', 'opalmegamenu'),
                            'icon'  => 'eicon-h-align-left',
                        ],
                        'center'  => [
                            'title' => __('Center', 'opalmegamenu'),
                            'icon'  => 'eicon-h-align-center',
                        ],
                        'right'   => [
                            'title' => __('Right', 'opalmegamenu'),
                            'icon'  => 'eicon-h-align-right',
                        ],
                        'justify' => [
                            'title' => __('Stretch', 'opalmegamenu'),
                            'icon'  => 'eicon-h-align-stretch',
                        ],
                    ],
                    'prefix_class' => 'opalelementor-nav-menu__align-',
                    'condition'    => [
                        'layout!' => 'dropdown',
                    ],
                ]
            );

            $this->add_control(
                'pointer',
                [
                    'label'     => __('Pointer', 'opalmegamenu'),
                    'type'      => Controls_Manager::SELECT,
                    'default'   => 'underline',
                    'options'   => [
                        'none'        => __('None', 'opalmegamenu'),
                        'underline'   => __('Underline', 'opalmegamenu'),
                        'overline'    => __('Overline', 'opalmegamenu'),
                        'double-line' => __('Double Line', 'opalmegamenu'),
                        'framed'      => __('Framed', 'opalmegamenu'),
                        'background'  => __('Background', 'opalmegamenu'),
                        'text'        => __('Text', 'opalmegamenu'),
                        'dot'         => __('Dot', 'opalmegamenu'),
                    ],
                    'condition' => [
                        'layout!' => 'dropdown',
                    ],
                ]
            );

            $this->add_control(
                'animation_line',
                [
                    'label'     => __('Animation', 'opalmegamenu'),
                    'type'      => Controls_Manager::SELECT,
                    'default'   => 'fade',
                    'options'   => [
                        'fade'     => 'Fade',
                        'slide'    => 'Slide',
                        'grow'     => 'Grow',
                        'drop-in'  => 'Drop In',
                        'drop-out' => 'Drop Out',
                        'none'     => 'None',
                    ],
                    'condition' => [
                        'layout!' => 'dropdown',
                        'pointer' => ['underline', 'overline', 'double-line'],
                    ],
                ]
            );

            $this->add_control(
                'animation_framed',
                [
                    'label'     => __('Animation', 'opalmegamenu'),
                    'type'      => Controls_Manager::SELECT,
                    'default'   => 'fade',
                    'options'   => [
                        'fade'    => 'Fade',
                        'grow'    => 'Grow',
                        'shrink'  => 'Shrink',
                        'draw'    => 'Draw',
                        'corners' => 'Corners',
                        'none'    => 'None',
                    ],
                    'condition' => [
                        'layout!' => 'dropdown',
                        'pointer' => 'framed',
                    ],
                ]
            );

            $this->add_control(
                'animation_background',
                [
                    'label'     => __('Animation', 'opalmegamenu'),
                    'type'      => Controls_Manager::SELECT,
                    'default'   => 'fade',
                    'options'   => [
                        'fade'                   => 'Fade',
                        'grow'                   => 'Grow',
                        'shrink'                 => 'Shrink',
                        'sweep-left'             => 'Sweep Left',
                        'sweep-right'            => 'Sweep Right',
                        'sweep-up'               => 'Sweep Up',
                        'sweep-down'             => 'Sweep Down',
                        'shutter-in-vertical'    => 'Shutter In Vertical',
                        'shutter-out-vertical'   => 'Shutter Out Vertical',
                        'shutter-in-horizontal'  => 'Shutter In Horizontal',
                        'shutter-out-horizontal' => 'Shutter Out Horizontal',
                        'none'                   => 'None',
                    ],
                    'condition' => [
                        'layout!' => 'dropdown',
                        'pointer' => 'background',
                    ],
                ]
            );

            $this->add_control(
                'animation_text',
                [
                    'label'     => __('Animation', 'opalmegamenu'),
                    'type'      => Controls_Manager::SELECT,
                    'default'   => 'grow',
                    'options'   => [
                        'grow'   => 'Grow',
                        'shrink' => 'Shrink',
                        'sink'   => 'Sink',
                        'float'  => 'Float',
                        'skew'   => 'Skew',
                        'rotate' => 'Rotate',
                        'none'   => 'None',
                    ],
                    'condition' => [
                        'layout!' => 'dropdown',
                        'pointer' => 'text',
                    ],
                ]
            );

            $this->add_control(
                'indicator',
                [
                    'label'        => __('Submenu Indicator', 'opalmegamenu'),
                    'type'         => Controls_Manager::SELECT,
                    'default'      => 'classic',
                    'options'      => [
                        'none'    => __('None', 'opalmegamenu'),
                        'classic' => __('Classic', 'opalmegamenu'),
                        'chevron' => __('Chevron', 'opalmegamenu'),
                        'angle'   => __('Angle', 'opalmegamenu'),
                        'plus'    => __('Plus', 'opalmegamenu'),
                    ],
                    'prefix_class' => 'opalelementor-nav-menu--indicator-',
                ]
            );

            $this->add_responsive_control(
                'subMenusMinWidth',
                [
                    'label'     => __('Min width Submenu(px)', 'opalmegamenu'),
                    'type'      => Controls_Manager::SLIDER,
                    'range'     => [
                        'px' => [
                            'min' => 50,
                            'max' => 100,
                        ],
                    ],
                    'default' => array(
                        'size' => 50
                    )
                ]
            );


            $this->add_responsive_control(
                'subMenusMaxWidth',
                [
                    'label'     => __('Max width Submenu(px)', 'opalmegamenu'),
                    'type'      => Controls_Manager::SLIDER,
                    'range'     => [
                        'px' => [
                            'min' => 100,
                            'max' => 1000,
                        ],
                    ],
                    'default' => array(
                        'size' => 500
                    )
                ]
            );

            $this->add_control(
                'heading_mobile_dropdown',
                [
                    'label'     => __('Mobile Dropdown', 'opalmegamenu'),
                    'type'      => Controls_Manager::HEADING,
                    'separator' => 'before',
                    'condition' => [
                        'layout!' => 'dropdown',
                    ],
                ]
            );

            $this->add_control(
                'enable_mobile_dropdown',
                [
                    'label'   => __('Enable Mobile Menu', 'opalmegamenu'),
                    'type'    => Controls_Manager::SWITCHER,
                    'default' => 'yes'
                ]
            );

            $this->add_control(
                'dropdown',
                [
                    'label'        => __('Breakpoint', 'opalmegamenu'),
                    'type'         => Controls_Manager::SELECT,
                    'default'      => 'tablet',
                    'options'      => [
                        'mobile' => __('Mobile (767px >)', 'opalmegamenu'),
                        'tablet' => __('Tablet (1023px >)', 'opalmegamenu'),
                    ],
                    'prefix_class' => 'opalelementor-nav-menu--dropdown-',
                    'condition'    => [
                        'layout!'                => 'dropdown',
                        'enable_mobile_dropdown' => 'yes'
                    ],
                ]
            );

            $this->add_control(
                'dropdown_style',
                [
                    'label'        => __('Style Display', 'opalmegamenu'),
                    'type'         => Controls_Manager::SELECT,
                    'default'      => 'default',
                    'options'      => [
                        'default'   => __('Default', 'opalmegamenu'),
                        'poup'      => __('Popup', 'opalmegamenu'),
                        'offcanvas' => __('Offcanvas', 'opalmegamenu'),
                    ],
                    'condition'    => [
                        'layout'                => 'dropdown',
                        'enable_mobile_dropdown' => 'yes'
                    ]
                ]
            );

            $this->add_control(
                'full_width',
                [
                    'label'              => __('Full Width', 'opalmegamenu'),
                    'type'               => Controls_Manager::SWITCHER,
                    'description'        => __('Stretch the dropdown of the menu to full width.', 'opalmegamenu'),
                    'prefix_class'       => 'opalelementor-nav-menu--',
                    'return_value'       => 'stretch',
                    'frontend_available' => true,
                    'condition'          => [
                        'enable_mobile_dropdown' => 'yes'
                    ],
                ]
            );

            $this->add_control(
                'text_align',
                [
                    'label'        => __('Align', 'opalmegamenu'),
                    'type'         => Controls_Manager::SELECT,
                    'default'      => 'aside',
                    'options'      => [
                        'aside'  => __('Aside', 'opalmegamenu'),
                        'center' => __('Center', 'opalmegamenu'),
                    ],
                    'prefix_class' => 'opalelementor-nav-menu__text-align-',
                    'condition'    => [
                        'enable_mobile_dropdown' => 'yes'
                    ],
                ]
            );

            $this->add_control(
                'toggle',
                [
                    'label'              => __('Toggle Button', 'opalmegamenu'),
                    'type'               => Controls_Manager::SELECT,
                    'default'            => 'burger',
                    'options'            => [
                        ''       => __('None', 'opalmegamenu'),
                        'burger' => __('Hamburger', 'opalmegamenu'),
                    ],
                    'prefix_class'       => 'opalelementor-nav-menu--toggle opalelementor-nav-menu--',
                    'render_type'        => 'template',
                    'frontend_available' => true,
                    'condition'          => [
                        'enable_mobile_dropdown' => 'yes'
                    ],
                ]
            );

            $this->add_control(
                'toggle_align',
                [
                    'label'                => __('Toggle Align', 'opalmegamenu'),
                    'type'                 => Controls_Manager::CHOOSE,
                    'default'              => 'center',
                    'options'              => [
                        'left'   => [
                            'title' => __('Left', 'opalmegamenu'),
                            'icon'  => 'eicon-h-align-left',
                        ],
                        'center' => [
                            'title' => __('Center', 'opalmegamenu'),
                            'icon'  => 'eicon-h-align-center',
                        ],
                        'right'  => [
                            'title' => __('Right', 'opalmegamenu'),
                            'icon'  => 'eicon-h-align-right',
                        ],
                    ],
                    'selectors_dictionary' => [
                        'left'   => 'margin-right: auto',
                        'center' => 'margin: 0 auto',
                        'right'  => 'margin-left: auto',
                    ],
                    'selectors'            => [
                        '{{WRAPPER}} .opalelementor-menu-toggle' => '{{VALUE}}',
                    ],
                    'condition'            => [
                        'toggle!'                => '',
                        'enable_mobile_dropdown' => 'yes'

                    ],
                    'label_block'          => false,
                ]
            );

            $this->end_controls_section();

            $this->start_controls_section(
                'section_style_main-menu',
                [
                    'label'     => __('Main Menu', 'opalmegamenu'),
                    'tab'       => Controls_Manager::TAB_STYLE,
                    'condition' => [
                        'layout!' => 'dropdown',
                    ],

                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'     => 'menu_typography',
                    'selector' => '{{WRAPPER}} .opalelementor-nav-menu--main',
                ]
            );

            $this->start_controls_tabs('tabs_menu_item_style');

            $this->start_controls_tab(
                'tab_menu_item_normal',
                [
                    'label' => __('Normal', 'opalmegamenu'),
                ]
            );

            $this->add_control(
                'color_menu_item',
                [
                    'label'     => __('Text Color', 'opalmegamenu'),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '',
                    'selectors' => [
                        '{{WRAPPER}} .opalelementor-nav-menu > li > .opalelementor-item' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'enable_divider',
                [
                    'label'     => __('Enable Divider', 'opalmegamenu'),
                    'type'      => Controls_Manager::SWITCHER,
                    'condition' => [
                        'layout' => 'horizontal',
                    ],
                ]
            );

            $this->add_control(
                'color_divider',
                [
                    'label'     => __('Divider Color', 'opalmegamenu'),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '',
                    'condition' => [
                        'enable_divider' => 'yes',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .opalelementor-nav-menu--divider > ul >li:after' => 'background-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_responsive_control(
                'height_divider',
                [
                    'label'     => __('Divider Padding', 'opalmegamenu'),
                    'type'      => Controls_Manager::SLIDER,
                    'range'     => [
                        'px' => [
                            'max' => 50,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .opalelementor-nav-menu--divider > ul >li:after' => 'height: {{SIZE}}{{UNIT}}; margin-top: calc(-{{SIZE}}{{UNIT}} / 2)',
                    ],
                    'condition' => [
                        'enable_divider' => 'yes',
                    ],
                ]
            );


            $this->end_controls_tab();

            $this->start_controls_tab(
                'tab_menu_item_hover',
                [
                    'label' => __('Hover', 'opalmegamenu'),
                ]
            );

            $this->add_control(
                'color_menu_item_hover',
                [
                    'label'     => __('Text Color', 'opalmegamenu'),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .opalelementor-nav-menu > li > .opalelementor-item:hover,
                        {{WRAPPER}} .opalelementor-nav-menu > li > .opalelementor-item.opalelementor-item-active,
                        {{WRAPPER}} .opalelementor-nav-menu > li > .opalelementor-item.highlighted,
                        {{WRAPPER}} .opalelementor-nav-menu > li > .opalelementor-item:focus' => 'color: {{VALUE}}',
                    ],
                    'condition' => [
                        'pointer!' => 'background',
                    ],
                ]
            );

            $this->add_control(
                'color_menu_item_hover_pointer_bg',
                [
                    'label'     => __('Text Color', 'opalmegamenu'),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '#fff',
                    'selectors' => [
                        '{{WRAPPER}} .opalelementor-nav-menu > li > .opalelementor-item:hover,
                        {{WRAPPER}} .opalelementor-nav-menu > li > .opalelementor-item.opalelementor-item-active,
                        {{WRAPPER}} .opalelementor-nav-menu > li > .opalelementor-item.highlighted,
                        {{WRAPPER}} .opalelementor-nav-menu > li > .opalelementor-item:focus' => 'color: {{VALUE}}',
                    ],
                    'condition' => [
                        'pointer' => 'background',
                    ],
                ]
            );

            $this->add_control(
                'pointer_color_menu_item_hover',
                [
                    'label'     => __('Pointer Color', 'opalmegamenu'),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '',
                    'selectors' => [
                        '{{WRAPPER}} .opalelementor-nav-menu--main:not(.e--pointer-framed) .opalelementor-item:before,
                        {{WRAPPER}} .opalelementor-nav-menu--main:not(.e--pointer-framed) .opalelementor-item:after' => 'background-color: {{VALUE}}',
                        '{{WRAPPER}} .e--pointer-framed .opalelementor-item:before,
                        {{WRAPPER}} .e--pointer-framed .opalelementor-item:after'            => 'border-color: {{VALUE}}',
                    ],
                    'condition' => [
                        'pointer!' => ['none', 'text'],
                    ],
                ]
            );

            $this->end_controls_tab();

            $this->start_controls_tab(
                'tab_menu_item_active',
                [
                    'label' => __('Active', 'opalmegamenu'),
                ]
            );

            $this->add_control(
                'color_menu_item_active',
                [
                    'label'     => __('Text Color', 'opalmegamenu'),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '',
                    'selectors' => [
                        '{{WRAPPER}} .opalelementor-nav-menu--main .opalelementor-item.opalelementor-item-active' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'pointer_color_menu_item_active',
                [
                    'label'     => __('Pointer Color', 'opalmegamenu'),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '',
                    'selectors' => [
                        '{{WRAPPER}} .opalelementor-nav-menu--main:not(.e--pointer-framed) .opalelementor-item.opalelementor-item-active:before,
                        {{WRAPPER}} .opalelementor-nav-menu--main:not(.e--pointer-framed) .opalelementor-item.opalelementor-item-active:after' => 'background-color: {{VALUE}}',
                        '{{WRAPPER}} .e--pointer-framed .opalelementor-item.opalelementor-item-active:before,
                        {{WRAPPER}} .e--pointer-framed .opalelementor-item.opalelementor-item-active:after'            => 'border-color: {{VALUE}}',
                    ],
                    'condition' => [
                        'pointer!' => ['none', 'text'],
                    ],
                ]
            );

            $this->end_controls_tab();

            $this->end_controls_tabs();

            /* This control is required to handle with complicated conditions */
            $this->add_control(
                'hr',
                [
                    'type'  => Controls_Manager::DIVIDER,
                    'style' => 'thick',
                ]
            );

            $this->add_control(
                'pointer_width',
                [
                    'label'     => __('Pointer Width', 'opalmegamenu'),
                    'type'      => Controls_Manager::SLIDER,
                    'devices'   => [self::RESPONSIVE_DESKTOP, self::RESPONSIVE_TABLET],
                    'range'     => [
                        'px' => [
                            'max' => 30,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .e--pointer-framed .opalelementor-item:before'                         => 'border-width: {{SIZE}}{{UNIT}}',
                        '{{WRAPPER}} .e--pointer-framed.e--animation-draw .opalelementor-item:before'       => 'border-width: 0 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}}',
                        '{{WRAPPER}} .e--pointer-framed.e--animation-draw .opalelementor-item:after'        => 'border-width: {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0 0',
                        '{{WRAPPER}} .e--pointer-framed.e--animation-corners .opalelementor-item:before'    => 'border-width: {{SIZE}}{{UNIT}} 0 0 {{SIZE}}{{UNIT}}',
                        '{{WRAPPER}} .e--pointer-framed.e--animation-corners .opalelementor-item:after'     => 'border-width: 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0',
                        '{{WRAPPER}} .e--pointer-underline .opalelementor-item:after,
                         {{WRAPPER}} .e--pointer-overline .opalelementor-item:before,
                         {{WRAPPER}} .e--pointer-double-line .opalelementor-item:before,
                         {{WRAPPER}} .e--pointer-double-line .opalelementor-item:after' => 'height: {{SIZE}}{{UNIT}}',
                    ],
                    'condition' => [
                        'pointer' => ['underline', 'overline', 'double-line', 'framed'],
                    ],
                ]
            );

            $this->add_responsive_control(
                'padding_horizontal_menu_item',
                [
                    'label'     => __('Horizontal Padding', 'opalmegamenu'),
                    'type'      => Controls_Manager::SLIDER,
                    'range'     => [
                        'px' => [
                            'max' => 50,
                        ],
                    ],
                    'devices'   => ['desktop', 'tablet'],
                    'selectors' => [
                        '{{WRAPPER}} .opalelementor-nav-menu--main .opalelementor-item' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}',
                    ],
                ]
            );


            $this->add_responsive_control(
                'padding_vertical_menu_item',
                [
                    'label'     => __('Vertical Padding', 'opalmegamenu'),
                    'type'      => Controls_Manager::SLIDER,
                    'range'     => [
                        'px' => [
                            'max' => 50,
                        ],
                    ],
                    'devices'   => ['desktop', 'tablet'],
                    'selectors' => [
                        '{{WRAPPER}} .opalelementor-nav-menu--main .opalelementor-item' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}}',
                    ],
                ]
            );

            $this->add_responsive_control(
                'menu_space_between',
                [
                    'label'     => __('Space Between', 'opalmegamenu'),
                    'type'      => Controls_Manager::SLIDER,
                    'range'     => [
                        'px' => [
                            'max' => 100,
                        ],
                    ],
                    'devices'   => ['desktop', 'tablet'],
                    'selectors' => [
                        'body:not(.rtl) {{WRAPPER}} .opalelementor-nav-menu--layout-horizontal .opalelementor-nav-menu > li:not(:last-child)'                 => 'margin-right: {{SIZE}}{{UNIT}}',
                        'body.rtl {{WRAPPER}} .opalelementor-nav-menu--layout-horizontal .opalelementor-nav-menu > li:not(:last-child)'                       => 'margin-left: {{SIZE}}{{UNIT}}',
                        '{{WRAPPER}} .opalelementor-nav-menu--main:not(.opalelementor-nav-menu--layout-horizontal) .opalelementor-nav-menu > li:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                    ],
                ]
            );

            $this->add_responsive_control(
                'border_radius_menu_item',
                [
                    'label'      => __('Border Radius', 'opalmegamenu'),
                    'type'       => Controls_Manager::SLIDER,
                    'size_units' => ['px', 'em', '%'],
                    'devices'    => ['desktop', 'tablet'],
                    'selectors'  => [
                        '{{WRAPPER}} .opalelementor-item:before'                                     => 'border-radius: {{SIZE}}{{UNIT}}',
                        '{{WRAPPER}} .e--animation-shutter-in-horizontal .opalelementor-item:before' => 'border-radius: {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0 0',
                        '{{WRAPPER}} .e--animation-shutter-in-horizontal .opalelementor-item:after'  => 'border-radius: 0 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}}',
                        '{{WRAPPER}} .e--animation-shutter-in-vertical .opalelementor-item:before'   => 'border-radius: 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0',
                        '{{WRAPPER}} .e--animation-shutter-in-vertical .opalelementor-item:after'    => 'border-radius: {{SIZE}}{{UNIT}} 0 0 {{SIZE}}{{UNIT}}',
                    ],
                    'condition'  => [
                        'pointer' => 'background',
                    ],
                ]
            );

            $this->end_controls_section();

            $this->start_controls_section(
                'section_style_dropdown',
                [
                    'label'     => __('Dropdown', 'opalmegamenu'),
                    'tab'       => Controls_Manager::TAB_STYLE,
                    'condition' => [
                        'enable_mobile_dropdown' => 'yes'
                    ],
                ]
            );

            $this->add_control(
                'dropdown_description',
                [
                    'raw'             => __('On desktop, this will affect the submenu. On mobile, this will affect the entire menu.', 'opalmegamenu'),
                    'type'            => Controls_Manager::RAW_HTML,
                    'content_classes' => 'opalelementor-descriptor',
                ]
            );

            $this->start_controls_tabs('tabs_dropdown_item_style');

            $this->start_controls_tab(
                'tab_dropdown_item_normal',
                [
                    'label' => __('Normal', 'opalmegamenu'),
                ]
            );

            $this->add_control(
                'color_dropdown_item',
                [
                    'label'     => __('Text Color', 'opalmegamenu'),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '',
                    'selectors' => [
                        '{{WRAPPER}} .opalelementor-nav-menu--dropdown a, {{WRAPPER}} .opalelementor-menu-toggle' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'background_color_dropdown_item',
                [
                    'label'     => __('Background Color', 'opalmegamenu'),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '',
                    'selectors' => [
                        '{{WRAPPER}} .opalelementor-nav-menu--dropdown' => 'background-color: {{VALUE}}',
                    ],
                    'separator' => 'none',
                ]
            );

            $this->end_controls_tab();

            $this->start_controls_tab(
                'tab_dropdown_item_hover',
                [
                    'label' => __('Hover', 'opalmegamenu'),
                ]
            );

            $this->add_control(
                'color_dropdown_item_hover',
                [
                    'label'     => __('Text Color', 'opalmegamenu'),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '',
                    'selectors' => [
                        '{{WRAPPER}} .opalelementor-nav-menu--dropdown a:hover, {{WRAPPER}} .opalelementor-menu-toggle:hover' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'background_color_dropdown_item_hover',
                [
                    'label'     => __('Background Color', 'opalmegamenu'),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '',
                    'selectors' => [
                        '{{WRAPPER}} .opalelementor-nav-menu--dropdown a:hover,
                        {{WRAPPER}} .opalelementor-nav-menu--dropdown a.highlighted' => 'background-color: {{VALUE}}',
                    ],
                    'separator' => 'none',
                ]
            );

            $this->end_controls_tab();

            $this->end_controls_tabs();

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'      => 'dropdown_typography',
                    'exclude'   => ['line_height'],
                    'selector'  => '{{WRAPPER}} .opalelementor-nav-menu--dropdown',
                    'separator' => 'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name'      => 'dropdown_border',
                    'selector'  => '{{WRAPPER}} .opalelementor-nav-menu--dropdown',
                    'separator' => 'before',
                ]
            );

            $this->add_responsive_control(
                'dropdown_border_radius',
                [
                    'label'      => __('Border Radius', 'opalmegamenu'),
                    'type'       => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%'],
                    'selectors'  => [
                        '{{WRAPPER}} .opalelementor-nav-menu--dropdown'                  => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        '{{WRAPPER}} .opalelementor-nav-menu--dropdown li:first-child a' => 'border-top-left-radius: {{TOP}}{{UNIT}}; border-top-right-radius: {{RIGHT}}{{UNIT}};',
                        '{{WRAPPER}} .opalelementor-nav-menu--dropdown li:last-child a'  => 'border-bottom-right-radius: {{BOTTOM}}{{UNIT}}; border-bottom-left-radius: {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name'     => 'dropdown_box_shadow',
                    'exclude'  => [
                        'box_shadow_position',
                    ],
                    'selector' => '{{WRAPPER}} .opalelementor-nav-menu--main .opalelementor-nav-menu--dropdown, {{WRAPPER}} .opalelementor-nav-menu__container.opalelementor-nav-menu--dropdown',
                ]
            );

            $this->add_responsive_control(
                'padding_horizontal_dropdown_item',
                [
                    'label'     => __('Horizontal Padding', 'opalmegamenu'),
                    'type'      => Controls_Manager::SLIDER,
                    'selectors' => [
                        '{{WRAPPER}} .opalelementor-nav-menu--dropdown a' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}',
                    ],
                    'separator' => 'before',

                ]
            );

            $this->add_responsive_control(
                'padding_vertical_dropdown_item',
                [
                    'label'     => __('Vertical Padding', 'opalmegamenu'),
                    'type'      => Controls_Manager::SLIDER,
                    'range'     => [
                        'px' => [
                            'max' => 50,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .opalelementor-nav-menu--dropdown a' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}}',
                    ],
                ]
            );

            $this->add_control(
                'heading_dropdown_divider',
                [
                    'label'     => __('Divider', 'opalmegamenu'),
                    'type'      => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name'     => 'dropdown_divider',
                    'selector' => '{{WRAPPER}} .opalelementor-nav-menu--dropdown li:not(:last-child)',
                    'exclude'  => ['width'],
                ]
            );

            $this->add_control(
                'dropdown_divider_width',
                [
                    'label'     => __('Border Width', 'opalmegamenu'),
                    'type'      => Controls_Manager::SLIDER,
                    'range'     => [
                        'px' => [
                            'max' => 50,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .opalelementor-nav-menu--dropdown li:not(:last-child)' => 'border-bottom-width: {{SIZE}}{{UNIT}}',
                    ],
                    'condition' => [
                        'dropdown_divider_border!' => '',
                    ],
                ]
            );

            $this->add_responsive_control(
                'dropdown_top_distance',
                [
                    'label'     => __('Distance', 'opalmegamenu'),
                    'type'      => Controls_Manager::SLIDER,
                    'range'     => [
                        'px' => [
                            'min' => -100,
                            'max' => 100,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .opalelementor-nav-menu--main > .opalelementor-nav-menu > li > .opalelementor-nav-menu--dropdown, {{WRAPPER}} .opalelementor-nav-menu__container.opalelementor-nav-menu--dropdown' => 'margin-top: {{SIZE}}{{UNIT}} !important',
                    ],
                    'separator' => 'before',
                ]
            );

            $this->end_controls_section();

            $this->start_controls_section('style_toggle',
                [
                    'label'     => __('Toggle Button', 'opalmegamenu'),
                    'tab'       => Controls_Manager::TAB_STYLE,
                    'condition' => [
                        'toggle!' => '',
                    ],
                ]
            );

            $this->start_controls_tabs('tabs_toggle_style');

            $this->start_controls_tab(
                'tab_toggle_style_normal',
                [
                    'label' => __('Normal', 'opalmegamenu'),
                ]
            );

            $this->add_control(
                'toggle_color',
                [
                    'label'     => __('Color', 'opalmegamenu'),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} div.opalelementor-menu-toggle' => 'color: {{VALUE}}', // Harder selector to override text color control
                    ],
                ]
            );

            $this->add_control(
                'toggle_background_color',
                [
                    'label'     => __('Background Color', 'opalmegamenu'),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .opalelementor-menu-toggle' => 'background-color: {{VALUE}}',
                    ],
                ]
            );

            $this->end_controls_tab();

            $this->start_controls_tab(
                'tab_toggle_style_hover',
                [
                    'label' => __('Hover', 'opalmegamenu'),
                ]
            );

            $this->add_control(
                'toggle_color_hover',
                [
                    'label'     => __('Color', 'opalmegamenu'),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} div.opalelementor-menu-toggle:hover' => 'color: {{VALUE}}', // Harder selector to override text color control
                    ],
                ]
            );

            $this->add_control(
                'toggle_background_color_hover',
                [
                    'label'     => __('Background Color', 'opalmegamenu'),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .opalelementor-menu-toggle:hover' => 'background-color: {{VALUE}}',
                    ],
                ]
            );

            $this->end_controls_tab();

            $this->end_controls_tabs();

            $this->add_control(
                'toggle_size',
                [
                    'label'     => __('Size', 'opalmegamenu'),
                    'type'      => Controls_Manager::SLIDER,
                    'range'     => [
                        'px' => [
                            'min' => 15,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .opalelementor-menu-toggle' => 'font-size: {{SIZE}}{{UNIT}}',
                    ],
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'toggle_border_width',
                [
                    'label'     => __('Border Width', 'opalmegamenu'),
                    'type'      => Controls_Manager::SLIDER,
                    'range'     => [
                        'px' => [
                            'max' => 10,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .opalelementor-menu-toggle' => 'border-width: {{SIZE}}{{UNIT}}',
                    ],
                ]
            );

            $this->add_control(
                'toggle_border_radius',
                [
                    'label'      => __('Border Radius', 'opalmegamenu'),
                    'type'       => Controls_Manager::SLIDER,
                    'size_units' => ['px', '%'],
                    'selectors'  => [
                        '{{WRAPPER}} .opalelementor-menu-toggle' => 'border-radius: {{SIZE}}{{UNIT}}',
                    ],
                ]
            );

            $this->end_controls_section();
        }

        protected function render() {
           
            $settings = $this->get_active_settings();

            $args = apply_filters( 'opal_nav_menu_args',[
                'echo'        => false,
                'menu'        => $settings['menu'],
                'menu_class'  => 'opalelementor-nav-menu',
                'menu_id'     => 'menu-' . $this->get_nav_menu_index() . '-' . $this->get_id(),
                'fallback_cb' => '__return_empty_string',
                'container'   => '',
            ] );

            if ('vertical' === $settings['layout']) {
                $args['menu_class'] .= ' sm-vertical';
            }

            // Add custom filter to handle Nav Menu HTML output.
            add_filter('nav_menu_link_attributes', [$this, 'handle_link_classes'], 10, 4);
            add_filter('nav_menu_submenu_css_class', [$this, 'handle_sub_menu_classes']);
            add_filter('nav_menu_item_id', '__return_empty_string');


            // General Menu.
            $menu_html = wp_nav_menu($args);

            // Dropdown Menu.
            $args['menu_id']    = 'menu-' . $this->get_nav_menu_index() . '-' . $this->get_id();
           //  $dropdown_menu_html = wp_nav_menu($args);

            // Remove all our custom filters.
            remove_filter('nav_menu_link_attributes', [$this, 'handle_link_classes']);
            remove_filter('nav_menu_submenu_css_class', [$this, 'handle_sub_menu_classes']);
            remove_filter('nav_menu_item_id', '__return_empty_string');

            if (empty($menu_html)) {
                return;
            }
            if ($settings['enable_mobile_dropdown'] === 'yes') {
                $this->add_render_attribute('menu-toggle', 'class', [
                    'opalelementor-menu-toggle',
                ]);

    //            if (Elementor\Plugin::instance()->elementor()->editor->is_edit_mode()) {
    //                $this->add_render_attribute('menu-toggle', [
    //                    'class' => 'opalelementor-clickable',
    //                ]);
    //            }
                $this->add_render_attribute('main-menu', 'class', 'opalelementor-nav-menu--mobile-enable');
            }

            $this->add_render_attribute('main-menu', 'data-subMenusMinWidth', $settings['subMenusMinWidth']['size']);
            $this->add_render_attribute('main-menu', 'data-subMenusMaxWidth', $settings['subMenusMaxWidth']['size']);


            if ('dropdown' !== $settings['layout']) :
                $this->add_render_attribute('main-menu', 'class', [
                    'opalelementor-nav-menu--main',
                    'opalelementor-nav-menu__container',
                    'opalelementor-nav-menu--layout-' . $settings['layout'],
                ]);

                if ($settings['enable_divider'] === 'yes') {
                    $this->add_render_attribute('main-menu', 'class', 'opalelementor-nav-menu--divider');
                }

                if ($settings['pointer']) :
                    $this->add_render_attribute('main-menu', 'class', 'e--pointer-' . $settings['pointer']);

                    foreach ($settings as $key => $value) :
                        if (0 === strpos($key, 'animation') && $value) :
                            $this->add_render_attribute('main-menu', 'class', 'e--animation-' . $value);

                            break;
                        endif;
                    endforeach;
                endif; ?>
                <nav <?php echo $this->get_render_attribute_string('main-menu'); ?>><?php echo $menu_html; ?></nav>
            <?php
            endif;

            if ( $settings['enable_mobile_dropdown'] === 'yes'):  
    //            $this->add_render_attribute('menu-toggle', 'data-canvas-id', 'opal-canvas-' . $this->get_id());

                    
                    $id = $args['menu_id'].rand(0 , 9 );
                    $this->add_render_attribute( 'menu-toggle', 'class', 'opalelementor-menu-toggle-wrap' );
                    $this->add_render_attribute( 'menu-toggle', 'data-style',  $settings['dropdown_style'] );
                    $this->add_render_attribute( 'menu-toggle', 'href',  "#".$id );
                    $this->add_render_attribute( 'menu-toggle', 'data-effect',  "mfp-zoom-in" );

                    $class = 'opalelementor-nav-menu__container';
                    if( $settings['dropdown_style'] == 'poup' ){
                         $class .= " mfp-hide opalelementor-nav-menu-popup opalelementor-nav-menu__text-align-center opalelementor-nav-menu--indicator-".$settings['indicator'] ;
                    } else {
                        $class .= ' opalelementor-nav-menu--dropdown ';
                    }
                ?>
                 
          
                <a <?php echo $this->get_render_attribute_string('menu-toggle'); ?>>
                    <i class="eicon" aria-hidden="true"></i>
                </a>
                <nav class="<?php echo $class; ?>" id="<?php echo $id; ?>"><?php echo $menu_html; ?></nav>
             

            <?php
            endif;
        }

        public function handle_link_classes($atts, $item, $args, $depth) {
            $classes = $depth ? 'opalelementor-sub-item' : 'opalelementor-item';

            if (in_array('current-menu-item', $item->classes)) {
                $classes .= '  opalelementor-item-active';
            }

            if (empty($atts['class'])) {
                $atts['class'] = $classes;
            } else {
                $atts['class'] .= ' ' . $classes;
            }

            return $atts;
        }

        public function handle_sub_menu_classes($classes) {
            $classes[] = 'opalelementor-nav-menu--dropdown';

            return $classes;
        }

        public function render_plain_content() {
        }
    }
}