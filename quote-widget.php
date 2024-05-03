<?php

class Quote_Widget extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'quote_widget';
    }

    public function get_title()
    {
        return __('Quote Widget', 'quote_widget_elementor');
    }

    public function get_icon()
    {
        return 'eicon-editor-quote';
    }

    public function get_categories()
    {
        return ['basic'];
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Content', 'quote_widget_elementor'),
            ]
        );

        $this->add_control(
            'quote_text',
            [
                'label' => __('Quote Text', 'quote_widget_elementor'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => __('Enter your quote here', 'quote_widget_elementor'),
                'default' => __('Your quote here', 'quote_widget_elementor'),
            ]
        );

        $this->add_control(
            'quote_logo',
            [
                'label' => __('Quote Logo', 'quote_widget_elementor'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'logo_label',
            [
                'label' => __('Logo Label', 'quote_widget_elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Logo Label', 'quote_widget_elementor'),
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $quote_text = $settings['quote_text'];
        $quote_logo = $settings['quote_logo']['url'];
        $logo_label = $settings['logo_label'];

        ?>

        <div class="quote-widget">
            <div class="quote-container">
                <div class="quote-text">
                    <p><?php echo $quote_text; ?></p>
                </div>
            </div>
            
            <div class="quote-logo">
                <img src="<?php echo $quote_logo; ?>" alt="Quote Logo">
            </div>
    
            <span class="logo-label"><?php echo $logo_label; ?></span>
        </div>

        <?php
    }
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Quote_Widget());
