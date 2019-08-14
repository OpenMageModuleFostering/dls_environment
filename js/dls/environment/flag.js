var DLSEnvironmentObjectFlags = new Class.create();
DLSEnvironmentObjectFlags.prototype =
{
    initialize : function(){

    },

    createEnvironmentFlags : function()
    {
        var current_env_vars = DLSEnvironmentObject.getCurrentEnvVars();

        var dlsHeaderEnvironmentFlagElement = document.getElementById("dls_environment_flag");
        var header = document.getElementsByClassName('logo')[0].parentNode;
        header.parentNode.insertBefore(dlsHeaderEnvironmentFlagElement, header.nextSibling);

        // Set styles
        dlsHeaderEnvironmentFlagElement.style.backgroundColor = current_env_vars.background_color;
        dlsHeaderEnvironmentFlagElement.style.color = current_env_vars.color;

        // Set content
        var dlsEnvHeaderFlagLabelElement = document.getElementById("dls_environment_flag_label");
        dlsEnvHeaderFlagLabelElement.innerHTML = current_env_vars.name + ' environment';

        dlsHeaderEnvironmentFlagElement.style.display = "block";
    },

    styleContentHeaderFloatingElement : function()
    {
        var current_env_vars = DLSEnvironmentObject.getCurrentEnvVars();

        // Set content-header-floating background_color
        var contentHeaderFloatingElements = document.getElementsByClassName('content-header-floating');

        for (var i = 0; i < contentHeaderFloatingElements.length; i++)
        {
            var contentHeaderFloatingElement = contentHeaderFloatingElements[i];
            contentHeaderFloatingElement.style.background = current_env_vars.background_color;
        }

        // Set the text color for the floating content header div if its CSS path follows base Magento
        var contentHeaderHeadingElement =
            document.querySelector("div.content-header-floating .content-header h3");

        if (!(contentHeaderHeadingElement === null))
        {
            contentHeaderHeadingElement.style.color = current_env_vars.color;
        }
    }
}

document.observe('dom:loaded', function () {
    DLSEnvironmentObjectFlagsObject.createEnvironmentFlags();
});

Event.observe(window, 'load', function(){
    DLSEnvironmentObjectFlagsObject.styleContentHeaderFloatingElement()
});
