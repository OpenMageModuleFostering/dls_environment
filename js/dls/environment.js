var DLSEnvironment = new Class.create();
DLSEnvironment.prototype = {
    initialize : function(dls_current_environment_config_json)
    {
        var dlsEnvironmentConfigJson = JSON.parse(dls_current_environment_config_json);

        this.current_env_vars = dlsEnvironmentConfigJson;
        this.foreground_is_light = true;
        this.foreground_is_dark_threshold = 650;

        this.initializeCurrentEnvVariables();
    },

    initializeCurrentEnvVariables : function()
    {
        this.determineForegroundColorBasedOnBackground();
    },

    determineForegroundColorBasedOnBackground : function()
    {
        var background_color = this.current_env_vars.background_color;
        // Remove the # in front of the color if it is set
        var first_char = background_color.charAt(0);
        if (first_char == '#')
        {
            background_color = background_color.substring(1);
        }

        if (background_color.length != 6)
        {
            // There's an issue with the color. Default to light for the foreground
            this.foreground_is_light = true;
        }

        var r_value = background_color.substring(0,2);
        var b_value = background_color.substring(2,4);
        var g_value = background_color.substring(4,6);

        var r_integer = parseInt(r_value, 16);
        var b_integer = parseInt(b_value, 16);
        var g_integer = parseInt(g_value, 16);

        if ((r_integer + b_integer + g_integer) < this.foreground_is_dark_threshold)
        {
            this.foreground_is_light = true;
        }
        else
        {
            this.foreground_is_light = false;
        }
    },

    getCurrentEnvVars : function()
    {
        return this.current_env_vars;
    }
}
