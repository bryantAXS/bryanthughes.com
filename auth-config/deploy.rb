

if !ENV['env'].nil? then
  set(:env, ENV['env'])
else
  set(:env, 'staging')
end

if !env.nil? && env == "production" then
  set :application, "bryanthughes.com"
  set :branch, "master"
else
  set :application, "bryanthughes.authenticff.com"
  set :branch, "dev"
end

set :user, 'root'
set :port, 24
set :ee_system, "system/expressionengine"
set :deploy_to, "/var/www/#{application}"

role :app, "198.58.109.239"
role :web, "198.58.109.239"
role :db,  "198.58.109.239", :primary => true

default_run_options[:pty] = true

# the git-clone url for your repository
set :repository, "git@codebasehq.com:thegoodlab/dimos/dims.git"

# Additional SCM settings
set :scm, :git
set :ssh_options, { :forward_agent => true }
set :deploy_via, :remote_cache
set :copy_strategy, :checkout
set :keep_releases, 3
set :copy_compression, :bz2

# Deployment process
after "deploy:update", "deploy:cleanup"
after "deploy", "deploy:set_permissions", "deploy:adjust_files"
after "deploy", "composer:copy_vendors", "composer:install"
# after "deploy", "migrate:migrate", "migrate:seed"

# Custom deployment tasks
namespace :deploy do

  desc "This is here to overide the original :restart"
  task :restart, :roles => :app do
    # do nothing but overide the default
  end

  desc "Remove files after deployment"
  task :set_permissions, :roles => :web do
    run "chmod -R 777 #{deploy_to}/current/storage"
    run "chmod -R 777 #{deploy_to}/current/bootstrap/cache"
  end

  desc "Adjust files after deployment"
  task :adjust_files, :roles => :web do
    run "rm #{deploy_to}/current/.env.example"
    run "mv #{deploy_to}/current/.env.#{env} #{deploy_to}/current/.env"
  end

end

#
# Custom composer tasks
#
namespace :composer do

  desc "Copy vendors from previous release"
  task :copy_vendors, :except => { :no_release => true } do
    run "if [ -d #{previous_release}/vendor ]; then cp -a #{previous_release}/vendor #{latest_release}/vendor; fi"
  end

  desc "Install composer updates"
  task :install do
    run "sh -c 'cd #{release_path} && composer install --no-dev --no-progress && composer update --no-dev --no-progress'"
  end

end

#
# Migrate and Seed
#
namespace :migrate do

  desc "Run active manual migration"
  task :migrate do
    run "php #{deploy_to}/current/artisan migrate --env=staging"
  end

  desc "Run DB seed"
  task :seed do
    run "php #{deploy_to}/current/artisan db:seed --env=staging"
  end

end
