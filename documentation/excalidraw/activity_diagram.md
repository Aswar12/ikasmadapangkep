# Activity Diagram: Program Kerja Management

## Alur Proses Program Kerja

```
┌───────────────────┐   ┌───────────────────┐   ┌───────────────────┐
│ Ketua Departemen  │   │       Sistem      │   │    Ketua Umum     │
├───────────────────┤   ├───────────────────┤   ├───────────────────┤
│        ●          │   │                   │   │                   │
│      Start        │   │                   │   │                   │
│        │          │   │                   │   │                   │
│        ▼          │   │                   │   │                   │
│  Draft Program    │   │                   │   │                   │
│  Kerja            │   │                   │   │                   │
│        │          │   │                   │   │                   │
│        ▼          │   │                   │   │                   │
│  Input detail     │   │                   │   │                   │
│  program          │   │                   │   │                   │
│        │          │   │                   │   │                   │
│        ▼          │   │                   │   │                   │
│  Submit Proposal  │──►│  Validate Input   │   │                   │
│                   │   │        │          │   │                   │
│                   │   │        ▼          │   │                   │
│                   │   │ Create Program    │   │                   │
│                   │   │ Record            │   │                   │
│                   │   │        │          │   │                   │
│                   │   │        ▼          │   │                   │
│                   │   │ Notify Ketua      │──►│ Review Program    │
│                   │   │ Umum              │   │ Proposal          │
│                   │   │                   │   │        │          │
│                   │   │                   │   │        ▼          │
│                   │   │                   │   │    Approved?      │
│                   │   │                   │   │    /     \        │
│                   │   │                   │   │   /       \       │
│                   │   │                   │   │  Yes      No      │
│                   │   │                   │   │  │         │      │
│                   │   │                   │   │  │         ▼      │
│                   │   │                   │   │  │    Request     │
│                   │   │                   │   │  │    Revision    │
│                   │   │                   │   │  │         │      │
│  Revise Program   │◄──│                   │◄──│  │         │      │
│  Proposal         │   │                   │   │  │         │      │
│        │          │   │                   │   │  │         │      │
│        └──────────┼──►│                   │───┼──┘         │      │
│                   │   │                   │   │            │      │
│                   │   │                   │◄──┼────────────┘      │
│                   │   │                   │   │                   │
│                   │   │  Update Status    │◄──┼───────────────────┘
│                   │   │  to "Approved"    │   │                   │
│                   │   │        │          │   │                   │
│                   │   │        ▼          │   │                   │
│                   │   │  Notify All       │   │                   │
│                   │   │  Stakeholders     │   │                   │
│                   │   │        │          │   │                   │
│                   │◄──┼────────┘          │   │                   │
│                   │   │                   │   │                   │
│  Implement        │   │                   │   │                   │
│  Program          │   │                   │   │                   │
│        │          │   │                   │   │                   │
│        ▼          │   │                   │   │                   │
│  Update Progress  │──►│ Calculate         │   │                   │
│  Regularly        │   │ Progress %        │   │                   │
│                   │   │        │          │   │                   │
│                   │   │        ▼          │   │                   │
│                   │   │ Generate          │   │                   │
│                   │   │ Progress Reports  │   │                   │
│                   │   │        │          │   │                   │
│                   │◄──┼────────┘          │   │                   │
│                   │   │                   │   │                   │
│  Program          │   │                   │   │                   │
│  Completed?       │   │                   │   │                   │
│   /      \        │   │                   │   │                   │
│  /        \       │   │                   │   │                   │
│ Yes       No      │   │                   │   │                   │
│  │        │       │   │                   │   │                   │
│  │        └───────┼───┼───────────────────┼───┼───────────────────┘
│  │                │   │                   │   │
│  ▼                │   │                   │   │
│ Submit Final      │──►│ Update Status     │   │
│ Report            │   │ to "Completed"    │   │
│                   │   │        │          │   │
│                   │   │        ▼          │   │
│                   │   │ Generate          │   │
│                   │   │ Completion Report │   │
│                   │   │        │          │   │
│                   │   │        ▼          │   │
│                   │   │       ●           │   │
│                   │   │      End          │   │
└───────────────────┘   └───────────────────┘   └───────────────────┘
```

## Tips Pembuatan di Excalidraw

1. Buat swimlanes vertikal untuk tiap aktor/sistem
2. Gunakan simbol:
   - Circle untuk start/end
   - Rectangle rounded untuk activities
   - Diamond untuk decision points
   - Arrow untuk flow
3. Beri label pada decision branches (Yes/No)
4. Pastikan semua path memiliki end point
5. Gunakan warna yang konsisten

## Activity Diagram Lainnya

Menggunakan template yang sama, buat diagram untuk:

1. **Payment Processing**
   - Aktor: Alumni, Sistem, Bendahara
   - Alur: Submit payment → Verify → Approve/Reject

2. **Event Registration**
   - Aktor: Alumni, Sistem, Koordinator Event
   - Alur: Create event → Register → Confirm

3. **MUBES Process**
   - Aktor: Ketua Umum, Sistem, Alumni, Presidium
   - Alur: Schedule → Conduct → Record decisions
