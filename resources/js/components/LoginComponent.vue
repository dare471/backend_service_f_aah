<template>
    <div>
        <h2>Login to Agro Management System</h2>
        <form @submit.prevent="login">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" v-model="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" v-model="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</template>

<script>
export default {
    name: 'LoginComponent',
    data() {
        return {
            email: '',
            password: ''
        };
    },
    methods: {
        async login() {
            const response = await fetch('/api/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ email: this.email, password: this.password }),
            });

            const data = await response.json();

            if (response.ok) {
                localStorage.setItem('token', data.access_token);
                window.location.href = '/dashboard';
            } else {
                alert('Login failed');
            }
        }
    }
};
</script>
