Vagrant.configure("2") do |config|
  config.vm.box = "debian/bookworm64"
  config.vm.network "forwarded_port", guest: 3306, host: 3306
  config.vm.network "forwarded_port", guest: 80, host: 8306
  config.vm.hostname = "portfolio-fo.local"

  config.vm.synced_folder ".", "/home/vagrant/portfolio-api"
  config.vm.provision "shell", path: "./vagrant/vagrant-setup.sh"
end
