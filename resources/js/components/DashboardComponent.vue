<template>
    <div>
        <h2>Dashboard</h2>
        <p>Welcome to the Agro Management System Dashboard. Here you can manage your farm activities, monitor crop growth, and track your agricultural data.</p>

        <div class="dashboard-sections">
            <div class="section">
                <h3>Farm Overview</h3>
                <p>Get a summary of your farm's current status, including active crops, weather conditions, and recent activities.</p>
            </div>
            <div class="section">
                <h3>Crop Management</h3>
                <p>Manage your crops, track their growth stages, and update their status.</p>
            </div>
            <div class="section">
                <h3>Activity Logs</h3>
                <p>Review logs of all activities on your farm, including planting, watering, and harvesting.</p>
            </div>
            <div class="section">
                <h3>Reports</h3>
                <p>Generate and view detailed reports on your farm's performance and productivity.</p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'DashboardComponent',
};
</script>

<style scoped>
.dashboard-sections {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-top: 20px;
}
.section {
    background-color: #e8f5e9;
    padding: 20px;
    border-radius: 8px;
}
.section h3 {
    margin-top: 0;
}
</style>
