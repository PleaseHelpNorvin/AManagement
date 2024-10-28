import 'package:flutter/material.dart';

class DashboardScreen extends StatelessWidget {
  final String userName;
  final String role; // Assuming 'admin' or 'tenant' as roles

  const DashboardScreen({
    Key? key,
    required this.userName,
    required this.role,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Dashboard'),
        actions: [
          IconButton(
            icon: Icon(Icons.logout),
            onPressed: () {
              // TODO: Implement logout functionality
            },
          )
        ],
      ),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Greeting Section
            Text(
              'Welcome, $userName!',
              style: TextStyle(
                fontSize: 24,
                fontWeight: FontWeight.bold,
              ),
            ),
            SizedBox(height: 8),
            Text(
              'Role: $role',
              style: TextStyle(
                fontSize: 16,
                color: Colors.grey[700],
              ),
            ),
            SizedBox(height: 16),

            // Dashboard Content Section
            Expanded(
              child: GridView.count(
                crossAxisCount: 2,
                children: [
                  DashboardCard(
                    icon: Icons.person,
                    title: 'Profile',
                    onTap: () {
                      // Navigate to Profile Page
                    },
                  ),
                  DashboardCard(
                    icon: Icons.payment,
                    title: 'Payments',
                    onTap: () {
                      // Navigate to Payments Page
                    },
                  ),
                  if (role == 'admin')
                    DashboardCard(
                      icon: Icons.supervised_user_circle,
                      title: 'Manage Users',
                      onTap: () {
                        // Navigate to Manage Users Page
                      },
                    ),
                  if (role == 'admin')
                    DashboardCard(
                      icon: Icons.notifications,
                      title: 'Notifications',
                      onTap: () {
                        // Navigate to Notifications Page
                      },
                    ),
                  // Add more cards as needed
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }
}

class DashboardCard extends StatelessWidget {
  final IconData icon;
  final String title;
  final VoidCallback onTap;

  const DashboardCard({
    Key? key,
    required this.icon,
    required this.title,
    required this.onTap,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Card(
      margin: EdgeInsets.all(8.0),
      elevation: 2,
      child: InkWell(
        onTap: onTap,
        child: Padding(
          padding: const EdgeInsets.all(16.0),
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Icon(icon, size: 48, color: Colors.blue),
              SizedBox(height: 16),
              Text(
                title,
                style: TextStyle(
                  fontSize: 18,
                  fontWeight: FontWeight.w500,
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}
