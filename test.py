description = "NVIDIA GeForce RTX 4080 Super | Stream Processing Units 10,240 | Boost Clock 2,700 MHz | Overclocked | 16 GB | GDDR6X Memory Type | Memory Interface 256 Bit | Memory Clock Speed 23 Gbps | Height (slots) 4 | Active Cooling System | DirectX support 12.2 | OpenGL Support 4.6 | Upscaling DLSS | G-Sync | PCIe 4.0 | Ray Tracing | 3x Display Port | HDMI | 7680 x 4320 | Dual Bios | 320 | GigaByte GeForce RTX 4080 Super AERO OC 16G | GigaByte GeForce RTX 4080 Super AORUS MASTER 16G | GigaByte GeForce RTX 4080 Super WINDFORCE V2 16G | GigaByte GeForce RTX 4080 Super GAMING OC 16G"

for char in description:
        if char.isspace():
            description = description.replace(char, " ")
print( description)
