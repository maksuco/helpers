# Maksuco Design System (AI Context)

This project uses a custom Tailwind CSS setup with specific component classes. **Always prefer these semantic classes** over raw utility strings when possible, to maintain consistency.


## Theme Configuration (`start.css`)
- **Main Colors**: `var(--color-brand)`, `var(--color-default-*)` (Default: Slate).
- **Radius**: `var(--btn-radius)`, `var(--box-radius)`.


## 1. Layout & Containers (`utilities.css`)
Use these for page structure and max-width constraints.

- **Sections**: Center content with max-widths.
  - `.section-xs` (48rem)
  - `.section-sm` (64rem)
  - `.section` (80rem - Default)
  - `.section-lg` (96rem)
  - `.section-xl` (110rem)
  - `.section-full` (100% width)
- **Grid**:
  - `.row`: Flex wrap wrapper.
  - `.bento`: 12-column grid (lg) or 2-column (sm) with auto rows.

### Spacing (Responsive Margins)
Use `.mt-*` classes which scale automatically across breakpoints (48rem, 64rem, 80rem).
- `.mt-xs`, `.mt-sm`, `.mt-md`, `.mt-lg`, `.mt-xl`

### Positioning
- `.absolute-full` (inset 0)
- `.absolute-c` (Center), `.absolute-cl` (Center Left), `.absolute-cr` (Center Right)
- `.absolute-tc` (Top Center), `.absoluteb-bc` (Bottom Center)

## 2. Boxes & Cards (`box.css`)
Base container style for panels, cards, and widgets.
Exposes the var(--box-radius) to inner elements

### Sizes (Padding & Radius)
- `.box-xxs`, `.box-xs`, `.box-sm`
- `.box` (Default)
- `.box-lg`, `.box-xl`, `.box-2xl`
- `.rounded-box` (Utility to apply box-radius without padding)

### Background Gradients
Apply these to any element to give it a subtle branded gradient background.
- **Monochrome**: `.box-50`, `.box-100`, `.box-800`, `.box-900`, `.box-950`
- **Brand**: `.box-brand-500`, `.box-brand-600`
- **Overlay**: `.box-bg-overlay` (Complex gradient + image overlay, supports hover effects)
- **Glass**: `.bg-frosted`

## 3. Typography (`text.css`)

### Headings
- `h1` (4xl, bold), `h2` (3xl), `h3` (2xl), `h4` (xl), `h5` (lg), `h6` (base)
- All headings automatically use `var(--heading-font)` and adaptive weights.

### Display Text (Hero/Marketing)
Huge, responsive text sizes for landing pages.
- `.text-display-xxs`
- `.text-display-xs`
- `.text-display-sm`
- `.text-display`
- `.text-display-lg`
- `.text-display-xl` (Massive 9rem-12rem)

### Utilities
- `.text-gradient`: Gradient text clip.
- `.font-muted`: Small uppercase tracking text.
- **Recursive Colors**: Apply color to *all* children recursively.
  - `.text-light-all`, `.text-default-all`, `.text-dark-all`, `.text-white-all`, `.text-black-all`

## Buttons (`btn.css`)
Base class: `.btn` (do not use alone, pair with variant)
Exposes the var(--btn-radius) to inner elements

### Variants
- **Solid**: `.btn-brand`, `.btn-default`, `.btn-black`, `.btn-white`, `.btn-dark`, `.btn-light`, `.btn-slate`, `.btn-gray`, `.btn-zinc`, `.btn-neutral`, `.btn-stone`, `.btn-red`, `.btn-orange`, `.btn-amber`, `.btn-yellow`, `.btn-lime`, `.btn-green`, `.btn-emerald`, `.btn-teal`, `.btn-cyan`, `.btn-sky`, `.btn-blue`, `.btn-indigo`, `.btn-violet`, `.btn-purple`, `.btn-fuchsia`, `.btn-pink`, `.btn-rose`
- **Outline**: `.btn-brand-outline`, `.btn-default-outline`, `.btn-black-outline` (and matching `-outline` for all colors above)
- **Special**: `.btn-transparent`, `.btn-label`

### Sizes
- `.btn-xs` (Extra small)
- `.btn-sm` (Small)
- `.btn-base` (Default, implied)
- `.btn-lg` (Large)
- `.btn-xl` (Extra large)

### Modifiers
- `.btn-full` (Full width)
- `.btn-icon-only` (Square aspect ratio for icons)
- `.rounded-btn` (Enforces button radius on inner elements)
- `.hover-magic` (Sophisticated hover effect with glow/shadow)
- `.btn-spinner` (Adds a loading spinner icon)
- `.btn-checked` (Adds a checkmark icon)

## Badges (`btn.css`)
Base class: `.badge`
- Variants: `.badge-brand`, `.badge-default`, `.badge-label`, `.badge-neutral`...
- Colors: `.badge-brand` ... `.badge-rose` (all standard Tailwind colors)
- Sizes: `.badge-xs`, `.badge-sm`, `.badge-lg`, `.badge-xl`

## Forms (`form.css`)

### Inputs
- `.form-basic`: Standard input (white/dark bg, bordered).
- `.form-muted`: Gray/muted background variant.
- Sizes: `.form-sm`, `.form-lg`, `.form-xl`

### Control Groups (`.form-combo`)
Use `.form-combo` to group inputs and buttons seamlessly.
- Children (inputs/buttons) automatically lose border-radius where they touch.
- Use `.combo-text` for static addons (e.g., "$", "USD").

### Navbar / Segmented Control
- `.form-navbar`: Container for a sliding segment control.
- Use with `<button>` elements.
- Active state: Add `.active` class to the active button.
- The background pill is handled automatically via CSS anchors/pseudo-elements.

### Toggles & Checks
- `.checkbox`: Custom styled checkbox.
- `.radio`: Custom styled radio button.
- `.form-switch`: Toggle switch (needs `type="checkbox"`).
  - Sizes: `.form-switch-sm`, `.form-switch-lg`.

### Validation
- `.form-success`: Adds checkmark icon on right.
- `.form-error`: Adds error icon on right.

### Dropdowns
Wrapper: `.dropdown`

### Modals
Wrapper: `.modal`
- **Sample**: `<div class="modal modal-center"><div class="modal-box"><div class="modal-btns"></div><div class="modal-body"></div><div class="modal-footer"></div></div></div>`

### Toast
Wrapper: `.toast`

## Special Effects & Utilities

### Shadows
- `.shadow-border`: Complex subtle border shadow using `glowing` logic.
- `.shadow-c`, `.shadow-b`: Custom drops with transitions.
- `.shadow-echos`: Rhythmic repeating shadow effect (often for brand visuals).

### Carousel
- `.carousel-browser`: Horizontal scroll snap container.
  - `.carousel-item`: Child items.
  - Modifiers: `.carousel-browser-fade` (cross-fade instead of scroll).
- `.carousel-linear`: Continuous infinite scrolling marquee.

### Animations
- `.hover-zoom`: Slight scale up on hover.
- `.bg-zoom`: Background image zoom on hover.
- `.bg-scroll`: Background position pans on hover.
- `.animate-fade-in`, `.animate-fade-out`.

### Miscellaneous
- `.fade-edges`: Mask to fade left/right edges (useful for scrollers).
- `.gradient-border`: Adds a gradient border via pseudo-element.
- `.text-facebook`, `.bg-facebook`, etc.: Social branding colors.
- `.scroll-x`: Allows horizontal scrolling.
- **Social Colors**: `.text-facebook`, `.bg-whatsapp`, etc.

---
*Note for AI: When generating UI, rely on these classes for "Maksuco" look-and-feel rather than inventing new Tailwind utility combinations.*
