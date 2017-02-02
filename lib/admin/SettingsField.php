<?php

namespace smartcat\admin;

if( !class_exists( '\smartcat\admin\SettingsField' ) ) :

abstract class SettingsField {
    protected $id;
    protected $option;
    protected $label = '';
    protected $desc = '';
    protected $value = '';
    protected $required = false;
    protected $args = array();
    protected $validators = array();

    public function __construct( array $args ) {
        $this->id = $args['id'];
        $this->option = $args['option'];
        $this->value = $args['value'];

        if( !empty( $args['required'] ) ) {
            $this->required = $args['required'];
        }

        if( !empty( $args['label'] ) ) {
            $this->label = $args['label'];
        }

        if( !empty( $args['validators' ] ) ) {
            $this->validators = $args['validators'];
        }

        if( !empty( $args['desc' ] ) ) {
            $this->desc = $args['desc'];
        }

        $this->args['label_for'] = $this->id;
    }

    public function get_id() {
        return $this->id;
    }

    public function register( $menu_slug, $section_slug ) {
        add_settings_field( $this->id, $this->label, array( $this, 'render' ), $menu_slug, $section_slug, $this->args );
        register_setting( $menu_slug, $this->option, array( $this, 'validate' ) );
    }

    public function validate( $value ) {
        foreach( $this->validators as $validator ) {
            $value = $validator->filter( $value );
        }

        return $value;
    }

    public abstract function render( array $args );
}

endif;