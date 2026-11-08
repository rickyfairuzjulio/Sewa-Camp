import os

items = {
    'tenda_dome_2p.jpg': ('#2D6A4F', '#52B788', 'TENDA DOME 2P', '&#9978;'),
    'tenda_dome_4p.jpg': ('#1B4332', '#40916C', 'TENDA DOME 4P', '&#9978;'),
    'carrier_60l.jpg': ('#264653', '#2A9D8F', 'CARRIER 60L', '&#127890;'),
    'carrier_45l.jpg': ('#3D5A80', '#98C1D9', 'CARRIER 45L', '&#127890;'),
    'sleeping_bag.jpg': ('#606C38', '#DDA15E', 'SLEEPING BAG', '&#128716;'),
    'matras_foil.jpg': ('#6C757D', '#ADB5BD', 'MATRAS FOIL', '&#129531;'),
    'kompor_portable.jpg': ('#E76F51', '#F4A261', 'KOMPOR CAMPING', '&#128293;'),
    'nesting_set.jpg': ('#495057', '#CED4DA', 'NESTING SET DS308', '&#127859;'),
    'headlamp_led.jpg': ('#E9C46A', '#F4A261', 'HEADLAMP LED', '&#128294;'),
    'lampu_tenda.jpg': ('#F39C12', '#F1C40F', 'LENTERA TENDA', '&#128161;'),
}

def make_svg(c1, c2, title, icon):
    return f"""<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 300" width="100%" height="100%">
  <defs>
    <linearGradient id="bg_{title.replace(' ', '_')}" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="{c1}"/>
      <stop offset="100%" stop-color="{c2}"/>
    </linearGradient>
  </defs>
  <rect width="400" height="300" rx="16" fill="url(#bg_{title.replace(' ', '_')})"/>
  <circle cx="200" cy="130" r="70" fill="rgba(255,255,255,0.18)"/>
  <text x="200" y="150" font-size="64" text-anchor="middle" dominant-baseline="central">{icon}</text>
  <rect x="30" y="230" width="340" height="44" rx="8" fill="rgba(0,0,0,0.3)"/>
  <text x="200" y="258" font-family="system-ui, sans-serif" font-weight="bold" font-size="16" fill="#ffffff" text-anchor="middle" letter-spacing="1">{title}</text>
</svg>"""

out_dir = r"c:\laragon\www\campsewa\public\uploads\alat"
os.makedirs(out_dir, exist_ok=True)

for name, (c1, c2, title, icon) in items.items():
    content = make_svg(c1, c2, title, icon)
    target_path = os.path.join(out_dir, name)
    with open(target_path, "w", encoding="utf-8") as f:
        f.write(content)

img_dir = r"c:\laragon\www\campsewa\public\images"
os.makedirs(img_dir, exist_ok=True)
with open(os.path.join(img_dir, "default-camp.svg"), "w", encoding="utf-8") as f:
    f.write(make_svg('#2D6A4F', '#74C69D', 'CAMPING GEAR', '&#127794;'))

logo = """<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 160 40" width="160" height="40">
  <path d="M12 32 L26 8 L40 32 Z" fill="#52B788"/>
  <path d="M26 8 L33 32 L19 32 Z" fill="#2D6A4F"/>
  <circle cx="9" cy="12" r="4" fill="#F4A261"/>
  <text x="48" y="27" font-family="system-ui, sans-serif" font-weight="900" font-size="21" fill="#1B4332">Camp<tspan fill="#40916C">Sewa</tspan></text>
</svg>"""
with open(os.path.join(img_dir, "logo.svg"), "w", encoding="utf-8") as f:
    f.write(logo)

print("SVGs created successfully!")
