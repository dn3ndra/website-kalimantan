document.addEventListener('DOMContentLoaded', function() {
    // Load Team Members
    async function loadTeamMembers() {
        try {
            const response = await fetch('includes/get_team.php');
            if (!response.ok) throw new Error('Failed to fetch team members');
            const result = await response.json();
            
            if (!result.success) throw new Error(result.error);
            
            const teamGrid = document.querySelector('.team-grid');
            const divisions = Object.keys(result.data);
            
            if (teamGrid && divisions.length > 0) {
                teamGrid.innerHTML = divisions.map(division => `
                    <div class="division-section">
                        <h3>${division}</h3>
                        <div class="members-grid">
                            ${result.data[division].map(member => `
                                <div class="team-member">
                                    <div class="member-image">
                                        <img src="${member.image_path}" alt="${member.nama}">
                                    </div>
                                    <div class="member-info">
                                        <h4>${member.nama}</h4>
                                        <p class="position">${member.jabatan}</p>
                                        <p class="nim">${member.nim}</p>
                                        <p class="program">${member.program_studi}</p>
                                        <p class="faculty">${member.fakultas}</p>
                                        <p class="origin">${member.asal_daerah}</p>
                                        <p class="birth">${member.tanggal_lahir} ${member.bulan_lahir}</p>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                `).join('');
            }
        } catch (error) {
            console.error('Error loading team members:', error);
        }
    }

    loadTeamMembers();
}); 