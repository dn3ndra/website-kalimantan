<?php
require_once '../config/database.php';

function getTeamMembers() {
    global $pdo;
    try {
        // Get all team members with custom ordering
        $stmt = $pdo->query("SELECT * FROM team_members WHERE 
            nim IS NOT NULL AND 
            program_studi IS NOT NULL AND 
            fakultas IS NOT NULL 
            ORDER BY 
            FIELD(divisi, 'Inti', 'Internal', 'Eksternal'),
            CASE 
                WHEN jabatan = 'Ketua' THEN 1
                WHEN jabatan = 'Wakil Ketua' THEN 2
                WHEN jabatan LIKE 'Sekretaris%' THEN 3
                WHEN jabatan LIKE 'Bendahara%' THEN 4
                WHEN jabatan = 'Steering Committe' THEN 5
                WHEN jabatan = 'Kepala Divisi' THEN 6
                ELSE 7
            END, 
            id ASC");
        
        $members = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Group members by division
        $grouped_members = [];
        foreach ($members as $member) {
            $divisi = $member['divisi'];
            if (!isset($grouped_members[$divisi])) {
                $grouped_members[$divisi] = [];
            }
            
            // Only include member if they have required data
            if (!empty($member['nim']) && !empty($member['program_studi']) && !empty($member['fakultas'])) {
                // Format member data, skip if value is NULL
                $formatted_member = [
                    'id' => $member['id'],
                    'nama' => $member['nama'] ?? '',
                    'jabatan' => $member['jabatan'] ?? '',
                    'nim' => $member['nim'] ?? '',
                    'program_studi' => $member['program_studi'] ?? '',
                    'fakultas' => $member['fakultas'] ?? '',
                    'asal_daerah' => $member['asal_daerah'] ?? '',
                    'tanggal_lahir' => $member['tanggal_lahir'] ?? '',
                    'bulan_lahir' => $member['bulan_lahir'] ?? '',
                    'image_path' => $member['image_path'] ?: 'images/default-profile.jpg'
                ];
                
                $grouped_members[$divisi][] = $formatted_member;
            }
        }

        // Ensure specific division order
        $ordered_members = [];
        $division_order = ['Inti', 'Internal', 'Eksternal'];
        
        foreach ($division_order as $division) {
            if (isset($grouped_members[$division]) && !empty($grouped_members[$division])) {
                $ordered_members[$division] = $grouped_members[$division];
            }
        }
        
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'data' => $ordered_members
        ]);
    } catch(PDOException $e) {
        error_log("Error fetching team members: " . $e->getMessage());
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => 'Failed to fetch team members',
            'message' => $e->getMessage()
        ]);
    }
}

getTeamMembers();
?> 