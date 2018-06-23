# -*- mode: ruby -*-
# vi: set ft=ruby :

# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

  config.vm.box = "debian/stretch64"

  config.vm.network "forwarded_port", guest: 80, host: 8080, host_ip: "127.0.0.1"


  config.vm.synced_folder ".", "/vagrant", type: "virtualbox"

  config.vm.provider "virtualbox" do |vb|
     # Display the VirtualBox GUI when booting the machine
     vb.gui = true

     # Customize the amount of memory on the VM:
     vb.memory = "5120"

     vb.cpus = "4"

     # cette ligne permet de corriger les liens symbolique
     vb.customize ["setextradata", :id, "VBoxInternal2/SharedFoldersEnableSymlinksCreate/v-root", "1"]
  end




  config.vm.provision "shell", inline: <<-SHELL
    apt-get update
    apt-get install -y ansible
    echo "[vagrant]" >> /etc/ansible/hosts
    echo "vagrant ansible_connection=local" >> /etc/ansible/hosts
    ansible-playbook /vagrant/provisioning/sample-playbook.yml --limit "vagrant"

  SHELL


end