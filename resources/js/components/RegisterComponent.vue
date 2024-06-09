<template>
    <div>
        <h2>Register for Agro Management System</h2>
        <form @submit.prevent="register">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" v-model="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" v-model="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" v-model="password" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm Password:</label>
                <input type="password" v-model="password_confirmation" required>
            </div>
            <button type="submit">Register</button>
        </form>
    </div>
</template>

<script>
export default {
    name: 'RegisterComponent',
    data() {
        return {
            name: '',
            email: '',
            password: '',
            password_confirmation: ''
        };
    },
    methods: {
        async register() {
            const response = await fetch('/api/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    name: this.name,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation
                }),
            });

            const data = await response.json();

            if (response.ok) {
                alert('Registration successful');
                window.location.href = '/login';
            } else {
                alert('Registration failed');
            }
        }
    }
};
</script>
