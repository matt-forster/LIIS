# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|
  
  config.vm.box = "precise32"
  config.vm.provision :shell, :path => "bootstrap.sh"
  config.vm.network :private_network, ip: "192.168.2.2"
  config.vm.network :forwarded_port, host: 8080, guest: 80

  config.vm.synced_folder "../liis-support", "/liis-support"
end
