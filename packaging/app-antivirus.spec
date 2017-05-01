
Name: app-antivirus
Epoch: 1
Version: 2.3.0
Release: 1%{dist}
Summary: Gateway Antivirus
License: GPLv3
Group: ClearOS/Apps
Source: %{name}-%{version}.tar.gz
Buildarch: noarch
Requires: %{name}-core = 1:%{version}-%{release}
Requires: app-base
Requires: app-network

%description
The Gateway Antivirus app uses a central antivirus engine to scan web, FTP, mail and more.  It protects devices connected to your network by stopping malware before it has a chance to reach your users.

%package core
Summary: Gateway Antivirus - Core
License: LGPLv3
Group: ClearOS/Libraries
Requires: app-base-core
Requires: app-events-core
Requires: app-network-core >= 1:2.3.28
Requires: app-tasks-core
Requires: clamav >= 0.99.2
Requires: /usr/bin/freshclam
Requires: /usr/sbin/clamd
Requires: /usr/bin/clamscan

%description core
The Gateway Antivirus app uses a central antivirus engine to scan web, FTP, mail and more.  It protects devices connected to your network by stopping malware before it has a chance to reach your users.

This package provides the core API and libraries.

%prep
%setup -q
%build

%install
mkdir -p -m 755 %{buildroot}/usr/clearos/apps/antivirus
cp -r * %{buildroot}/usr/clearos/apps/antivirus/

install -D -m 0755 packaging/antivirus %{buildroot}/var/clearos/events/network_configuration/antivirus
install -D -m 0644 packaging/app-antivirus.cron %{buildroot}/etc/cron.d/app-antivirus
install -D -m 0755 packaging/clamav-check.sh %{buildroot}/usr/sbin/clamav-check.sh
install -D -m 0644 packaging/clamd.php %{buildroot}/var/clearos/base/daemon/clamd.php
install -D -m 0755 packaging/freshclam-update %{buildroot}/usr/sbin/freshclam-update
install -D -m 0755 packaging/network-connected-event %{buildroot}/var/clearos/events/network_connected/antivirus

%post
logger -p local6.notice -t installer 'app-antivirus - installing'

%post core
logger -p local6.notice -t installer 'app-antivirus-core - installing'

if [ $1 -eq 1 ]; then
    [ -x /usr/clearos/apps/antivirus/deploy/install ] && /usr/clearos/apps/antivirus/deploy/install
fi

[ -x /usr/clearos/apps/antivirus/deploy/upgrade ] && /usr/clearos/apps/antivirus/deploy/upgrade

exit 0

%preun
if [ $1 -eq 0 ]; then
    logger -p local6.notice -t installer 'app-antivirus - uninstalling'
fi

%preun core
if [ $1 -eq 0 ]; then
    logger -p local6.notice -t installer 'app-antivirus-core - uninstalling'
    [ -x /usr/clearos/apps/antivirus/deploy/uninstall ] && /usr/clearos/apps/antivirus/deploy/uninstall
fi

exit 0

%files
%defattr(-,root,root)
/usr/clearos/apps/antivirus/controllers
/usr/clearos/apps/antivirus/htdocs
/usr/clearos/apps/antivirus/views

%files core
%defattr(-,root,root)
%exclude /usr/clearos/apps/antivirus/packaging
%exclude /usr/clearos/apps/antivirus/unify.json
%dir /usr/clearos/apps/antivirus
/usr/clearos/apps/antivirus/deploy
/usr/clearos/apps/antivirus/language
/usr/clearos/apps/antivirus/libraries
/var/clearos/events/network_configuration/antivirus
/etc/cron.d/app-antivirus
/usr/sbin/clamav-check.sh
/var/clearos/base/daemon/clamd.php
/usr/sbin/freshclam-update
/var/clearos/events/network_connected/antivirus
