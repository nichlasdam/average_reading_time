<?php
class MySettingsPage
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Settings Admin', 
            'Avg Reading time', 
            'manage_options', 
            'my-setting-admin', 
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        
        // Set class property
        $this->options = get_option( 'Words_per_minute', 250 );
        ?>
        <div class="wrap">
            <?php screen_icon(); ?>
            <h2>Average Reading Time Settings</h2>           
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'average_reading_time' );   
                do_settings_sections( 'my-setting-admin' );
                submit_button(); 
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {    
        $example_array = array('Words_per_minute' => 250);
        if ($this->options['Words_per_minute'] == false OR $this->options['Words_per_minute'] == 0) {
               update_option('Words_per_minute',  $example_array);
        }
        register_setting(
            'average_reading_time', // Option group
            'words_per_minute', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            'My Custom Settings', // Title
            array( $this, 'print_section_info' ), // Callback
            'my-setting-admin' // Page
        );  

        add_settings_field(
            'Words_per_minute', // ID
            'Words per minute', // Title 
            array( $this, 'id_number_callback' ), // Callback
            'my-setting-admin', // Page
            'setting_section_id' // Section           
        );        
    }
    
    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['Words_per_minute'] ) ) {
            $new_input['Words_per_minute'] = absint( $input['Words_per_minute'] );
        }
        else {
            $new_input['Words_per_minute'] = 250;   
        }
        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Enter your custom settings below:';
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function id_number_callback()
    {
        printf(
            '<input type="text" id="Words_per_minute" name="words_per_minute[Words_per_minute]" value="%s" />',
            isset( $this->options['Words_per_minute'] ) ? esc_attr( $this->options['Words_per_minute']) : ''
        );
    }

}

if( is_admin() )
    $my_settings_page = new MySettingsPage();