# Cara Menggunakan Diagram PlantUML dengan Excalidraw

## Pendahuluan

Karena format PlantUML (.puml) dan Excalidraw (.excalidraw) menggunakan struktur yang berbeda, konversi langsung dari satu format ke format lainnya tidak memungkinkan. Namun, Anda dapat menggunakan kedua tool ini bersama-sama dengan cara berikut:

## Opsi 1: Menggunakan PlantUML dan Excalidraw secara terpisah

### Untuk PlantUML:
1. **Render file PlantUML menjadi gambar**:
   - Instal ekstensi PlantUML di VS Code
   - Atau gunakan website [PlantUML Server](http://www.plantuml.com/plantuml/uml/)
   - Atau gunakan command line tool: `java -jar plantuml.jar diagram.puml`

2. **Export diagram sebagai PNG/SVG**:
   - Menggunakan PlantUML server: klik tombol "PNG" atau "SVG"
   - Menggunakan VS Code: klik kanan pada diagram > "Export Diagram"

### Untuk Excalidraw:
1. **Buat diagram di Excalidraw**:
   - Buka [Excalidraw](https://excalidraw.com/)
   - Buat diagram Anda secara manual
   - Ikuti panduan di folder `excalidraw/README.md`

## Opsi 2: Import PlantUML ke Excalidraw sebagai Referensi

1. **Render PlantUML menjadi PNG/SVG** seperti pada opsi 1
2. **Import gambar ke Excalidraw**:
   - Buka Excalidraw
   - Gunakan menu: File > Import > Image
   - Pilih file PNG/SVG dari diagram PlantUML Anda
3. **Gunakan gambar sebagai referensi**:
   - Letakkan gambar yang diimpor sebagai layer paling bawah
   - Buat ulang diagram di atasnya menggunakan bentuk Excalidraw
   - Setelah selesai, hapus gambar referensi jika diperlukan

## Opsi 3: Konversi PlantUML ke Format Menengah

1. **Konversi PlantUML ke format DOT**:
   ```
   java -jar plantuml.jar -tdot diagram.puml
   ```
2. **Konversi DOT ke SVG**:
   ```
   dot -Tsvg diagram.dot > diagram.svg
   ```
3. **Import SVG ke Excalidraw** seperti pada Opsi 2

## Opsi 4: Gunakan Exporter Khusus (Solusi Paling Praktis)

1. **Instal PlantUML Exporter untuk Excalidraw**:
   - Gunakan plugin [PlantUML to Excalidraw Converter](https://github.com/excalidraw/excalidraw-libraries)
   - Atau gunakan tools online untuk konversi

2. **Gunakan layanan konversi online**:
   - Beberapa situs menawarkan konversi dari diagram ke format Excalidraw-compatible

## Rekomendasi Untuk Project IKA SMADA Pangkep

Untuk project IKA SMADA Pangkep, rekomendasi terbaik adalah:

1. **Pertahankan diagram PlantUML sebagai dokumentasi teknis resmi**
2. **Gunakan Excalidraw untuk presentasi visual dan diskusi dengan stakeholder**
3. **Untuk presentasi, render diagram PlantUML menjadi PNG dan import ke Excalidraw**
4. **Edit dan tambahkan elemen visual di Excalidraw untuk meningkatkan presentasi**

## Lokasi File

- Diagram PlantUML: `C:\laragon\www\ikasmadapangkep\documentation\*.puml`
- Panduan Excalidraw: `C:\laragon\www\ikasmadapangkep\documentation\excalidraw\README.md`
