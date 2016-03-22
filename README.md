# Crystalis

Crystalis is an extension for the [Enterprise Content Management Framework TYPO3 CMS](http://typo3.org/), released under
the GNU GPL. Crystalis is copyright (c) 2012–2016 by Daniel Haring.

This document covers installation and basic usage of Crystalis. A more in-depth documentation about available features
and how Crystalis works exactly can be found at:

* https://docs.typo3.org/typo3cms/extensions/crystalis/

## Preparation

Crystalis requires a working
[installation of TYPO3 CMS](https://docs.typo3.org/typo3cms/GettingStartedTutorial/Installation/Index.html), version 6.2
or higher.

Please make sure to have one up and running before continue reading.

It is assumed that you have at least basic knowledge about TYPO3 CMS. If you need support in installing and using TYPO3
CMS, please refer to the [Official Documentation](http://typo3.org/documentation/).

## What does it do?

Crystalis is intended to be used as a headstone for newly built websites using TYPO3 CMS. It is shipped with an own
content rendering logic, provides a HTML5 video content element, supports you in handling languages and makes some
smaller improvements which should lower the effort building your site.

## Available versions

For better transparency, the version number of Crystalis also indicates the TYPO3 CMS version required to run properly.

There will be versions for every TYPO3 CMS LTS ("Long term support") release which is currently supported at the
official level, and in addition one version for the most recent release of TYPO3 CMS.

The master branch represents the cutting-edge state of the extension and does not necessarily run flawlessly and in many
cases even is not intended to do so. Whereas the release branches are fully tested with the respective version of TYPO3
CMS and should work without downsides.

## Installation

Basically there are three ways to implement Crystalis into your TYPO3 CMS environment:

 - By using the official way through the TYPO3 Extension Repository (TER)
 - By downloading a ZIP-file out of the available branches/releases
 - By using git via command line

Please choose the method you're most comfortable with and continue reading.

### Installing via TYPO3 Extension Repository (TER)

The most intuitive way of installing Crysalis is by using the Extension Manager module of your TYPO3 CMS environment.

Please keep in mind, that there could only exist one recent version of Crystalis in TER. If you are using an older
release of TYPO3 CMS (e.g. 6.2 LTS) you should consider using one of the other methods.

Installing Crystalis via TER works as follows:

1. Log into the Backend of your TYPO3 CMS installation
2. Switch to module *Extension Manager*
3. From the select-box at the upper right corner, choose "Get Extensions"
4. In the search field at the top type "crystalis"
5. Click the "Import and Install" action left beside the extension name
6. TYPO3 CMS now will take care about installing and activating Crystalis

### Installing via ZIP-file

Installing Crystalis from a downloaded ZIP file has the advantage that you have access to the most recent release of
every branch/version.

To install Crystalis via ZIP-file please do the following:

1. Download the release branch of your choice (e.g. Crystalis-6.2)
2. Unpack the ZIP-file into the following directory of your TYPO3 CMS installation: *typo3conf/ext*
3. Rename the extracted folder to *crystalis* and ensure your web server has at least reading access to it
4. Log into the Backend of your TYPO3 CMS installation
5. Switch to module *Extension Manager*
6. Crystalis should appear at the lower half of the extension list. Click the "Activate" button on it's left and you're
   done.

### Installing via command line

Using the command line allows you to fine-tune access rights and even keep track of future changes made to Crystalis.

This method requires git to be installed.

To install Crystalis via command line on Unix like systems, please follow these steps:

Change to the extension directory of your TYPO3 CMS installation:
```bash
cd typo3conf/ext
```

Clone the desired branch of Crystalis (here: *Crystalis-6.2*):
```bash
git clone -b Crystalis-6.2 https://github.com/DanielHaring/TYPO3-Crystalis.git crystalis
```

(Optional) Remove git related files to avoid tracking:
```bash
rm -R crystalis/.git/
```

Grant write access to your web server (assuming the group name of your web server is '_www'):
```bash
chown -R :_www crystalis/ && chmod -R g+w crystalis/
```

Follow steps 4–6 of *Installing via ZIP-file*