%include Solaris.inc

Name:			TSpca
Summary:		Patch Check Advanced
Version:		20081218-01
Source1:		pca

SUNW_BaseDir:        %{_basedir}
BuildRoot:           %{_tmppath}/%{name}-%{version}-build
%include default-depend.inc

# Requires:

%prep
%setup -q -T -c -n %name-%version
cp %SOURCE1 .

%build

%install
rm -rf $RPM_BUILD_ROOT
mkdir -p $RPM_BUILD_ROOT%{_bindir}
cp pca $RPM_BUILD_ROOT%{_bindir}

%clean
rm -rf $RPM_BUILD_ROOT

%files
%defattr (-, root, root)
%{_bindir}
