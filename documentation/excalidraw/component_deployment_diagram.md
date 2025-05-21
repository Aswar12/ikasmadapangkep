# Component & Deployment Diagram IKA SMADA Pangkep

## Component Diagram

```
┌─────────────────────────────────────────────────────────┐
│                    Frontend Layer                       │
│                                                         │
│   ┌───────────────┐            ┌───────────────┐        │
│   │ Web Interface │            │ Mobile View   │        │
│   └───────┬───────┘            └───────┬───────┘        │
│           │                            │                │
└───────────┼────────────────────────────┼────────────────┘
            │                            │
            ▼                            ▼
┌─────────────────────────────────────────────────────────┐
│                     API Layer                           │
│                                                         │
│   ┌───────────────┐            ┌───────────────┐        │
│   │   REST API    │            │   Auth Svc    │        │
│   └───────┬───────┘            └───────┬───────┘        │
│           │                            │                │
└───────────┼────────────────────────────┼────────────────┘
            │                            │
            ▼                            ▼
┌─────────────────────────────────────────────────────────┐
│                  Business Logic Layer                   │
│                                                         │
│   ┌───────────────┐       ┌────────────────┐            │
│   │ User Mgmt     │◄─────►│  Department    │            │
│   └───────────────┘       │  Management    │            │
│                           └────────────────┘            │
│   ┌───────────────┐       ┌────────────────┐            │
│   │ Event Mgmt    │◄─────►│  Financial     │            │
│   └───────────────┘       │  Management    │            │
│                           └────────────────┘            │
│   ┌───────────────┐       ┌────────────────┐            │
│   │ Gallery Mgmt  │◄─────►│  Notification  │            │
│   └───────────────┘       │  Service       │            │
│                           └────────────────┘            │
└─────────────────────────────────────────────────────────┘
                │
                ▼
┌─────────────────────────────────────────────────────────┐
│                  Data Access Layer                      │
│                                                         │
│   ┌───────────────┐       ┌────────────────┐            │
│   │ Query Builder │       │  Repository    │            │
│   └───────────────┘       │  Layer         │            │
│                           └────────────────┘            │
│                                                         │
└─────────────────────────────────────────────────────────┘
                │
                ▼
┌─────────────────────────────────────────────────────────┐
│                     Database                            │
│                                                         │
│   ┌───────────────────────────────────────────────┐     │
│   │              MySQL Database                    │     │
│   └───────────────────────────────────────────────┘     │
│                                                         │
└─────────────────────────────────────────────────────────┘
```

## Deployment Diagram

```
┌───────────────────────────┐      
│     Client Devices        │      
│ ┌───────────────────────┐ │      
│ │     Web Browser       │ │      
│ └───────────────────────┘ │      
│ ┌───────────────────────┐ │      
│ │     Mobile Device     │ │      
│ └───────────────────────┘ │      
└───────────────┬───────────┘      
                │                 
                │ HTTPS           
                ▼                 
┌───────────────────────────┐      
│       Web Server          │      
│ ┌───────────────────────┐ │      
│ │      Nginx/Apache     │ │      
│ └───────────────────────┘ │      
│ ┌───────────────────────┐ │      
│ │      Laravel App      │ │      
│ └───────────────────────┘ │      
└─┬─────────────────────┬───┘      
  │                     │         
  │                     │         
  ▼                     ▼         
┌───────────────┐   ┌───────────────┐
│ Database      │   │ File Storage  │
│ Server        │   │               │
│ ┌───────────┐ │   │ ┌───────────┐ │
│ │  MySQL    │ │   │ │  Minio/S3 │ │
│ └───────────┘ │   │ └───────────┘ │
└───────────────┘   └───────────────┘
```

## Component Diagram: Penjelasan

### Layer Arsitektur
1. **Frontend Layer**
   - Web Interface: Antarmuka berbasis browser
   - Mobile View: Tampilan responsif untuk perangkat mobile

2. **API Layer**
   - REST API: Titik akses utama untuk frontend
   - Auth Service: Manajemen otentikasi dan otorisasi

3. **Business Logic Layer**
   - User Management: Pengelolaan pengguna dan profil
   - Department Management: Pengelolaan departemen dan program kerja
   - Event Management: Pengelolaan acara dan pendaftaran
   - Financial Management: Pengelolaan iuran dan keuangan
   - Gallery Management: Pengelolaan album dan foto
   - Notification Service: Layanan pengiriman pemberitahuan

4. **Data Access Layer**
   - Query Builder: Pembangun query database
   - Repository Layer: Abstraksi akses data

5. **Database**
   - MySQL Database: Penyimpanan data utama

## Deployment Diagram: Penjelasan

### Infrastructure Components
1. **Client Devices**
   - Web Browser: Chrome, Firefox, Safari, dll
   - Mobile Device: Smartphone, Tablet

2. **Web Server**
   - Nginx/Apache: Web server
   - Laravel App: Aplikasi utama IKA SMADA Pangkep

3. **Database Server**
   - MySQL: Database relasional

4. **File Storage**
   - Minio/S3: Penyimpanan file (dokumen, foto, dll)

## Tips Pembuatan di Excalidraw

### Component Diagram
1. Gunakan rectangle untuk komponen dan layers
2. Gunakan nested rectangle untuk sub-komponen
3. Gunakan arrow untuk menunjukkan dependencies
4. Gunakan warna berbeda untuk layer yang berbeda

### Deployment Diagram
1. Gunakan 3D boxes untuk nodes
2. Nested components ditampilkan di dalam node
3. Gunakan arrow dengan label untuk communication paths
4. Gunakan cloud shape untuk representasi cloud services
