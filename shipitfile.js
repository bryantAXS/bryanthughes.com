module.exports = function (shipit) {

  require('shipit-deploy')(shipit);
  require('shipit-shared')(shipit);

  shipit.initConfig({

    //
    // Defaults
    //
    default: {

      // Codebase details
      workspace: '.tmp',
      repositoryUrl: 'git@codebasehq.com:thegoodlab/personal-projects/bryanthughescom.git',
      branch: 'master',
      ignores: ['.git'],
      keepReleases: 2,
      key: '~/.ssh/id_rsa',
      shallowClone: true,

      // Shared directory details
      shared: {
        overwrite: true,
        dirs: ['craft/storage']
        // You can symlink files too
        // files: ['public/uploads']
      },

    },

    //
    // Production
    //
    production: {
      deployTo: '/var/www/bryanthughes.com',
      keepReleases: 2,
      servers: ['root@198.58.109.239:24'],
    }

  });

  shipit.on('published', function () {

    var current = shipit.releasePath;
    var environment = shipit.environment;

    // .then(function(){
    //     return shipit.remote('chmod -R 777 ' + current + "/public/content");
    // })

    return shipit.remote('echo "Post Deployment Tasks"').then(function(){
        return shipit.remote('chmod -R 777 ' + current + '/craft/storage');
    }).then(function(){
        return shipit.remote('rm ' + current + "/public/.htaccess");
    }).then(function(){
        return shipit.remote('mv ' + current + "/public/.htaccess." + environment + " " + current + "/public/.htaccess");
    }).then(function(){
        return shipit.remote('rm ' + current + "/public/robots.txt");
    }).then(function(){
        return shipit.remote('mv ' + current + "/public/robots.txt." + environment + " " + current + "/public/robots.txt");
    });

  });

};
