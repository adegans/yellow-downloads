# Downloads 1.0.1

Easily add a download to your page using a simple to use shortcode.

## Usage

Without a path, downloads are expected to be in the main Downloads folder (default: /media/downloads)

Standard download:
```
[download filename.zip]
```

If your file is a in a subfolder in /media/downloads:
```
[download subfolder/filename.zip]
```

Multiple files:
```
[download filename.zip another.zip]
```

## Customization
Apply CSS to `p.download-item` and `p.download-item a` to customize the fonts and colors.
Other tags used inside the paragraph are `small` and `strong`.

## Changelog:

1.0.1 - 2025-11-28
* Updated - indentation
* i18n - Language tags for english
* Fix - File header comment

## How to install an extension

[Download ZIP file](https://github.com/adegans/yellow-downloads/archive/refs/heads/main.zip) and copy it into your `system/extensions` folder. [Learn more about extensions](https://github.com/annaesvensson/yellow-update).

## Developer

Arnan de Gans
