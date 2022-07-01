(function ($, Drupal, drupalSettings) {

    Drupal.behaviors.doProjectsBehavior = {
       attach: function (context, settings) {
         // This is where we're storing the JSON from the Drupal.org API response.
         var projects = drupalSettings.doProjects.projects;

         var modules = {};
         // Use underscore to filter the API response to only the fields we care about
         // title and download count.
         _.map(projects.list, function (project, i) {
             modules[project.title] = project.field_download_count;
           });

         // We use the template functionality of underscore to simplify the HTML output
         // of our block.
         var output = _.template("<li><%= title %>: <%= download_count %></li>");

         var blockContent = '<ul>';
         // Using the each method we can iterrate over our modules object and pass the
         // values through our underscore template.
         _.each(modules, function(count, name) {
           blockContent += output({"title": name, "download_count": count});
         });

         blockContent += '</ul>';
         // Do the work of replacing the block content with our Module names and count.
         $('#block-doprojectlistingblock .content').html(blockContent);
       }
    }
})(jQuery, Drupal, drupalSettings);
