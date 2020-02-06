# Gallery Captions for WooCommerce

Adds the title & caption of each image in a Product Gallery to the Single-Product pages so customers can read them!


## Known Issues:

### Image captions may be hidden when different variations are selected
If product image magnification is on WooCommerce doesn't seem to update the height of the element that contains the images when swapping to a new variation image, so if the new image is taller than the old one some of the content below the image, (and part of the new image itself), may be hidden.

### Conflict with [WooCommerce Additional Variation Images](https://woocommerce.com/products/woocommerce-additional-variation-images/) Extension

#### Missing HTML
WooCommerce Additional Variation Images uses an AJAX request to load an updated gallery for each product. When it makes this request the HTML doesn't pass through the same generation process as normal, so Gallery Captions can't be added. I am reaching out to WooCommerce to try to resolve this issue, but if you work there please [get in touch](https://johnbeales.com/get-in-touch/), (or [@johnbeales](https://twitter.com/johnbeales) in Twitter). I know how to fix this!

#### Hidden Caption
When the HTML is generated properly WooCommerce Additional Variation Images also makes all image containers the same height, which means that captions are sometimes pushed out of the container and hidden. One solution to this is to style the captions as overlays at the bottom of the images. This CSS should do the trick:

```
.gcw-caption {
    position: absolute;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 100;
    background:rgba(0,0,0,0.7);
    color: white;
}
```

Making all the images for each product the same size may also fix the problem.