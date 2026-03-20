<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Candidates Export</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #4F46E5;
            padding-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background: #4F46E5;
            color: white;
            padding: 8px;
            font-size: 10px;
        }
        td {
            padding: 6px;
            border-bottom: 1px solid #ddd;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 8px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>ASPN Overseas - Candidates Report</h2>
        <p>Generated on: {{ $generated_at }} | Total: {{ $total }} candidates</p>
    </div>
    
     <table>
        <thead>
             <tr>
                <th>Candidate ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Trade</th>
                <th>Status</th>
                <th>Registered</th>
             </tr>
        </thead>
        <tbody>
            @foreach($candidates as $candidate)
             <tr>
                <td>{{ $candidate->candidate_id }}</td>
                <td>{{ $candidate->full_name }}</td>
                <td>{{ $candidate->email }}</td>
                <td>{{ $candidate->phone }}</td>
                <td>{{ $candidate->trade_name }}</td>
                <td>{{ ucfirst($candidate->status) }}</td>
                <td>{{ $candidate->registered_at->format('d M Y') }}</td>
             </tr>
            @endforeach
        </tbody>
     </table>
    
    <div class="footer">
        <p>This report was generated automatically by ASPN Overseas System</p>
    </div>
</body>
</html>