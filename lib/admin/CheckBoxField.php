<?php

namespace smartcat\admin;

if( !class_exists( '\smartcat\admin\CheckBoxField' ) ) :

    class CheckBoxField extends SettingsField {

        public function render( array $args ) { ?>

            <input type="checkbox"
                id="<?php esc_attr_e( $this->id ); ?>"
                name="<?php esc_attr_e( $this->option ); ?>"

                <?php checked( $this->value, 'on' ); ?>
                <?php echo $this->required ? 'required="required"' : ''; ?> />

            <label for="<?php esc_attr_e( $this->id ); ?>"><?php echo $this->desc; ?></label>

        <?php }
    }

endif;