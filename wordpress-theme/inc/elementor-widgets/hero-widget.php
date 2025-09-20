<?php
/**
 * WordPress Master Developer Theme - Hero Widget for Elementor
 * 
 * @package WordPress_Master_Developer
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Hero Widget Class
 */
class WP_Master_Dev_Hero_Widget extends \Elementor\Widget_Base {
    
    /**
     * Get widget name
     */
    public function get_name() {
        return 'wp-master-hero';
    }
    
    /**
     * Get widget title
     */
    public function get_title() {
        return esc_html__('WP Master Hero', 'wp-master-dev');
    }
    
    /**
     * Get widget icon
     */
    public function get_icon() {
        return 'eicon-banner';
    }
    
    /**
     * Get widget categories
     */
    public function get_categories() {
        return ['wp-master-dev'];
    }
    
    /**
     * Get widget keywords
     */
    public function get_keywords() {
        return ['hero', 'banner', 'header', 'wp-master'];
    }
    
    /**
     * Register widget controls
     */
    protected function register_controls() {
        
        // Content Section
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'wp-master-dev'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        
        $this->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'wp-master-dev'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('WordPress Master Developer', 'wp-master-dev'),
                'placeholder' => esc_html__('Enter your title', 'wp-master-dev'),
                'label_block' => true,
            ]
        );
        
        $this->add_control(
            'subtitle',
            [
                'label' => esc_html__('Subtitle', 'wp-master-dev'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Professional WordPress Development', 'wp-master-dev'),
                'placeholder' => esc_html__('Enter your subtitle', 'wp-master-dev'),
                'label_block' => true,
            ]
        );
        
        $this->add_control(
            'description',
            [
                'label' => esc_html__('Description', 'wp-master-dev'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('Transform your digital presence with custom WordPress solutions. From concept to launch, we deliver exceptional websites that drive results.', 'wp-master-dev'),
                'placeholder' => esc_html__('Enter your description', 'wp-master-dev'),
                'rows' => 4,
            ]
        );
        
        $this->add_control(
            'button_text',
            [
                'label' => esc_html__('Button Text', 'wp-master-dev'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Get Started', 'wp-master-dev'),
                'placeholder' => esc_html__('Enter button text', 'wp-master-dev'),
            ]
        );
        
        $this->add_control(
            'button_link',
            [
                'label' => esc_html__('Button Link', 'wp-master-dev'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'wp-master-dev'),
                'default' => [
                    'url' => '#contact',
                    'is_external' => false,
                    'nofollow' => false,
                ],
            ]
        );
        
        $this->add_control(
            'secondary_button_text',
            [
                'label' => esc_html__('Secondary Button Text', 'wp-master-dev'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('View Portfolio', 'wp-master-dev'),
                'placeholder' => esc_html__('Enter secondary button text', 'wp-master-dev'),
            ]
        );
        
        $this->add_control(
            'secondary_button_link',
            [
                'label' => esc_html__('Secondary Button Link', 'wp-master-dev'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'wp-master-dev'),
                'default' => [
                    'url' => '#portfolio',
                    'is_external' => false,
                    'nofollow' => false,
                ],
            ]
        );
        
        $this->end_controls_section();
        
        // Background Section
        $this->start_controls_section(
            'background_section',
            [
                'label' => esc_html__('Background', 'wp-master-dev'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        
        $this->add_control(
            'background_type',
            [
                'label' => esc_html__('Background Type', 'wp-master-dev'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'gradient',
                'options' => [
                    'gradient' => esc_html__('Gradient', 'wp-master-dev'),
                    'image' => esc_html__('Image', 'wp-master-dev'),
                    'video' => esc_html__('Video', 'wp-master-dev'),
                    'particles' => esc_html__('Particles', 'wp-master-dev'),
                ],
            ]
        );
        
        $this->add_control(
            'background_image',
            [
                'label' => esc_html__('Background Image', 'wp-master-dev'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => 'https://images.unsplash.com/photo-1551434678-e076c223a692?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                ],
                'condition' => [
                    'background_type' => 'image',
                ],
            ]
        );
        
        $this->add_control(
            'background_overlay',
            [
                'label' => esc_html__('Background Overlay', 'wp-master-dev'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'wp-master-dev'),
                'label_off' => esc_html__('No', 'wp-master-dev'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'background_type!' => 'gradient',
                ],
            ]
        );
        
        $this->end_controls_section();
        
        // Style Section
        $this->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('Style', 'wp-master-dev'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_control(
            'text_align',
            [
                'label' => esc_html__('Text Alignment', 'wp-master-dev'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'wp-master-dev'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'wp-master-dev'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'wp-master-dev'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'toggle' => true,
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Title Typography', 'wp-master-dev'),
                'selector' => '{{WRAPPER}} .hero-title',
            ]
        );
        
        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Title Color', 'wp-master-dev'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .hero-title' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'subtitle_typography',
                'label' => esc_html__('Subtitle Typography', 'wp-master-dev'),
                'selector' => '{{WRAPPER}} .hero-subtitle',
            ]
        );
        
        $this->add_control(
            'subtitle_color',
            [
                'label' => esc_html__('Subtitle Color', 'wp-master-dev'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#f59e0b',
                'selectors' => [
                    '{{WRAPPER}} .hero-subtitle' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'label' => esc_html__('Description Typography', 'wp-master-dev'),
                'selector' => '{{WRAPPER}} .hero-description',
            ]
        );
        
        $this->add_control(
            'description_color',
            [
                'label' => esc_html__('Description Color', 'wp-master-dev'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#e5e7eb',
                'selectors' => [
                    '{{WRAPPER}} .hero-description' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->end_controls_section();
        
        // Button Style Section
        $this->start_controls_section(
            'button_style_section',
            [
                'label' => esc_html__('Button Style', 'wp-master-dev'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'label' => esc_html__('Button Typography', 'wp-master-dev'),
                'selector' => '{{WRAPPER}} .hero-button',
            ]
        );
        
        $this->add_control(
            'button_padding',
            [
                'label' => esc_html__('Button Padding', 'wp-master-dev'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default' => [
                    'top' => 12,
                    'right' => 24,
                    'bottom' => 12,
                    'left' => 24,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .hero-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_control(
            'button_border_radius',
            [
                'label' => esc_html__('Border Radius', 'wp-master-dev'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => 6,
                    'right' => 6,
                    'bottom' => 6,
                    'left' => 6,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .hero-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->end_controls_section();
    }
    
    /**
     * Render widget output on the frontend
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        
        $background_class = 'hero-bg-' . $settings['background_type'];
        $text_align_class = 'text-' . $settings['text_align'];
        
        ?>
        <div class="wp-master-hero-widget">
            <section class="hero-section <?php echo esc_attr($background_class); ?> <?php echo esc_attr($text_align_class); ?>">
                
                <?php if ($settings['background_type'] === 'image' && !empty($settings['background_image']['url'])): ?>
                    <div class="hero-background">
                        <img src="<?php echo esc_url($settings['background_image']['url']); ?>" alt="<?php echo esc_attr($settings['title']); ?>">
                        <?php if ($settings['background_overlay'] === 'yes'): ?>
                            <div class="hero-overlay"></div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($settings['background_type'] === 'gradient'): ?>
                    <div class="hero-gradient-bg"></div>
                <?php endif; ?>
                
                <?php if ($settings['background_type'] === 'particles'): ?>
                    <div id="particles-js" class="hero-particles"></div>
                <?php endif; ?>
                
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="hero-content">
                                
                                <?php if (!empty($settings['subtitle'])): ?>
                                    <div class="hero-subtitle" data-animation="fadeInUp" data-delay="0.2s">
                                        <?php echo esc_html($settings['subtitle']); ?>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($settings['title'])): ?>
                                    <h1 class="hero-title" data-animation="fadeInUp" data-delay="0.4s">
                                        <?php echo esc_html($settings['title']); ?>
                                    </h1>
                                <?php endif; ?>
                                
                                <?php if (!empty($settings['description'])): ?>
                                    <p class="hero-description" data-animation="fadeInUp" data-delay="0.6s">
                                        <?php echo esc_html($settings['description']); ?>
                                    </p>
                                <?php endif; ?>
                                
                                <div class="hero-buttons" data-animation="fadeInUp" data-delay="0.8s">
                                    
                                    <?php if (!empty($settings['button_text'])): ?>
                                        <a href="<?php echo esc_url($settings['button_link']['url']); ?>" 
                                           class="hero-button btn-primary"
                                           <?php echo $settings['button_link']['is_external'] ? 'target="_blank"' : ''; ?>
                                           <?php echo $settings['button_link']['nofollow'] ? 'rel="nofollow"' : ''; ?>>
                                            <?php echo esc_html($settings['button_text']); ?>
                                        </a>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($settings['secondary_button_text'])): ?>
                                        <a href="<?php echo esc_url($settings['secondary_button_link']['url']); ?>" 
                                           class="hero-button btn-secondary"
                                           <?php echo $settings['secondary_button_link']['is_external'] ? 'target="_blank"' : ''; ?>
                                           <?php echo $settings['secondary_button_link']['nofollow'] ? 'rel="nofollow"' : ''; ?>>
                                            <?php echo esc_html($settings['secondary_button_text']); ?>
                                        </a>
                                    <?php endif; ?>
                                    
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                
            </section>
        </div>
        
        <style>
        .wp-master-hero-widget .hero-section {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            overflow: hidden;
        }
        
        .hero-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -2;
        }
        
        .hero-background img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: -1;
        }
        
        .hero-gradient-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 50%, #1e3a8a 100%);
            z-index: -2;
        }
        
        .hero-particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
        }
        
        .hero-subtitle {
            font-size: 1.125rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 1rem;
        }
        
        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            line-height: 1.1;
            margin-bottom: 1.5rem;
        }
        
        .hero-description {
            font-size: 1.25rem;
            line-height: 1.6;
            margin-bottom: 2rem;
        }
        
        .hero-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }
        
        .hero-button {
            display: inline-flex;
            align-items: center;
            padding: 0.75rem 2rem;
            font-weight: 600;
            text-decoration: none;
            border-radius: 0.375rem;
            transition: all 0.3s ease;
        }
        
        .hero-button.btn-primary {
            background-color: #2563eb;
            color: #ffffff;
        }
        
        .hero-button.btn-primary:hover {
            background-color: #1d4ed8;
            transform: translateY(-2px);
        }
        
        .hero-button.btn-secondary {
            background-color: transparent;
            color: #ffffff;
            border: 2px solid #ffffff;
        }
        
        .hero-button.btn-secondary:hover {
            background-color: #ffffff;
            color: #2563eb;
        }
        
        .text-center .hero-buttons {
            justify-content: center;
        }
        
        .text-right .hero-buttons {
            justify-content: flex-end;
        }
        
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-description {
                font-size: 1.125rem;
            }
            
            .hero-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .hero-button {
                width: 100%;
                max-width: 300px;
                justify-content: center;
            }
        }
        </style>
        <?php
    }
    
    /**
     * Render widget output in the editor
     */
    protected function content_template() {
        ?>
        <#
        var backgroundClass = 'hero-bg-' + settings.background_type;
        var textAlignClass = 'text-' + settings.text_align;
        #>
        
        <div class="wp-master-hero-widget">
            <section class="hero-section {{ backgroundClass }} {{ textAlignClass }}">
                
                <# if (settings.background_type === 'image' && settings.background_image.url) { #>
                    <div class="hero-background">
                        <img src="{{ settings.background_image.url }}" alt="{{ settings.title }}">
                        <# if (settings.background_overlay === 'yes') { #>
                            <div class="hero-overlay"></div>
                        <# } #>
                    </div>
                <# } #>
                
                <# if (settings.background_type === 'gradient') { #>
                    <div class="hero-gradient-bg"></div>
                <# } #>
                
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="hero-content">
                                
                                <# if (settings.subtitle) { #>
                                    <div class="hero-subtitle">{{ settings.subtitle }}</div>
                                <# } #>
                                
                                <# if (settings.title) { #>
                                    <h1 class="hero-title">{{ settings.title }}</h1>
                                <# } #>
                                
                                <# if (settings.description) { #>
                                    <p class="hero-description">{{ settings.description }}</p>
                                <# } #>
                                
                                <div class="hero-buttons">
                                    
                                    <# if (settings.button_text) { #>
                                        <a href="{{ settings.button_link.url }}" class="hero-button btn-primary">
                                            {{ settings.button_text }}
                                        </a>
                                    <# } #>
                                    
                                    <# if (settings.secondary_button_text) { #>
                                        <a href="{{ settings.secondary_button_link.url }}" class="hero-button btn-secondary">
                                            {{ settings.secondary_button_text }}
                                        </a>
                                    <# } #>
                                    
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                
            </section>
        </div>
        <?php
    }
}
