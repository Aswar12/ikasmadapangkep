# Sequence Diagram untuk IKA SMADA Pangkep

## Sequence Diagram: Registrasi Alumni

```
┌─────────┐     ┌──────────┐     ┌──────────┐      ┌─────────┐     ┌─────────┐
│ Alumni  │     │   Form   │     │ Auth Ctrl│      │  Mail   │     │  Admin  │
└────┬────┘     └─────┬────┘     └────┬─────┘      └────┬────┘     └────┬────┘
     │                │               │                 │               │
     │ Fill Form      │               │                 │               │
     │───────────────>│               │                 │               │
     │                │  Validate     │                 │               │
     │                │──────┐        │                 │               │
     │                │      │        │                 │               │
     │                │<─────┘        │                 │               │
     │                │               │                 │               │
     │                │ Submit Data   │                 │               │
     │                │───────────────>                 │               │
     │                │               │ Create Account  │               │
     │                │               │──────┐          │               │
     │                │               │      │          │               │
     │                │               │<─────┘          │               │
     │                │               │                 │               │
     │                │               │ Send Verification Email         │
     │                │               │───────────────────────>         │
     │                │               │                 │               │
     │ Email Received │               │                 │               │
     │<────────────────────────────────────────────────>               │
     │                │               │                 │               │
     │ Click Verify Link              │                 │               │
     │───────────────────────────────>│                 │               │
     │                │               │                 │               │
     │                │               │ Update Status   │               │
     │                │               │──────┐          │               │
     │                │               │      │          │               │
     │                │               │<─────┘          │               │
     │                │               │                 │               │
     │                │               │ Notify Admin    │               │
     │                │               │───────────────────────────────>│
     │                │               │                 │               │
     │                │               │                 │               │ Review
     │                │               │                 │               │──────┐
     │                │               │                 │               │      │
     │                │               │                 │               │<─────┘
     │                │               │                 │               │
     │                │               │ Approve/Reject  │               │
     │                │               │<───────────────────────────────│
     │                │               │                 │               │
     │                │               │ Send Notification              │
     │                │               │───────────────────────>        │
     │                │               │                 │               │
     │ Notification   │               │                 │               │
     │<────────────────────────────────────────────────>               │
     │                │               │                 │               │
     │ Login          │               │                 │               │
     │───────────────>│               │                 │               │
     │                │               │                 │               │
     │ Access Granted │               │                 │               │
     │<───────────────│               │                 │               │
     │                │               │                 │               │
```

## Sequence Diagram: Pembayaran Iuran

```
┌─────────┐     ┌──────────┐     ┌──────────┐      ┌──────────┐
│ Alumni  │     │ Payment  │     │ System   │      │Bendahara │
└────┬────┘     └─────┬────┘     └────┬─────┘      └────┬─────┘
     │ Submit Payment │               │                 │
     │───────────────>│               │                 │
     │                │  Validate     │                 │
     │                │──────┐        │                 │
     │                │      │        │                 │
     │                │<─────┘        │                 │
     │                │               │                 │
     │                │ Create Record │                 │
     │                │───────────────>                 │
     │                │               │                 │
     │                │               │ Notify Bendahara│
     │                │               │────────────────>│
     │                │               │                 │
     │                │               │                 │ Review
     │                │               │                 │──────┐
     │                │               │                 │      │
     │                │               │                 │<─────┘
     │                │               │                 │
     │                │               │ Approve/Reject  │
     │                │               │<────────────────│
     │                │               │                 │
     │                │               │ Update Status   │
     │                │               │──────┐          │
     │                │               │      │          │
     │                │               │<─────┘          │
     │                │               │                 │
     │ Notification   │               │                 │
     │<───────────────────────────────│                 │
     │                │               │                 │
```

## Tips Pembuatan di Excalidraw

1. Buat rectangle untuk setiap participant di bagian atas
2. Buat garis vertikal putus-putus (lifeline) di bawah setiap participant
3. Gunakan arrow horizontal untuk message antar participant
4. Gunakan rectangle tipis pada lifeline untuk activation
5. Urutan waktu berjalan dari atas ke bawah
6. Message return (optional) digambarkan dengan garis putus-putus
7. Untuk self-call, gambar arrow yang kembali ke lifeline yang sama

## Sequence Diagram Lainnya

Menggunakan template yang sama, buat diagram untuk:

1. **Program Kerja Creation**
   - Participants: Ketua Departemen, Program Controller, System, Ketua Umum
   - Flow: Create → Validate → Approve → Implement

2. **MUBES Process**
   - Participants: Ketua Umum, MUBES Controller, System, Alumni, Presidium
   - Flow: Schedule → Notify → Register → Conduct → Record
