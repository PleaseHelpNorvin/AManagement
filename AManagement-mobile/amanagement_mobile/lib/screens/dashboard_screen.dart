import 'package:flutter/material.dart';
import '../screens/inner-screens/profile_screen.dart';
import '../screens/inner-screens/payment_screen.dart';
import '../widgets/appbar_without_backbutton.dart';
import 'package:provider/provider.dart';
import 'package:amanagement_mobile/providers/auth_provider.dart'; // Make sure the import path is correct

class DashboardScreen extends StatelessWidget {
  final String name;
  final String role;
  final dynamic token;

  const DashboardScreen({
    super.key,
    required this.token,
    required this.role,
    required this.name,
  });

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: getAppBarWithoutBackButton('Dashboard'),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Profile Information Card
            ProfileCard(name: name, role: role),

            const SizedBox(height: 16),

            // Dashboard Buttons
            Expanded(
              child: GridView.count(
                crossAxisCount: 2,
                children: [
                  DashboardCard(
                    icon: Icons.person,
                    title: 'Profile',
                    onTap: () {
                      Navigator.of(context).push(
                        MaterialPageRoute(
                          builder: (context) => const ProfileScreen(),
                        ),
                      );
                    },
                  ),
                  DashboardCard(
                    icon: Icons.payment,
                    title: 'Payments',
                    onTap: () {
                      Navigator.of(context).push(
                        MaterialPageRoute(
                          builder: (context) => const PaymentsScreen(),
                        ),
                      );
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

// ProfileCard Widget
class ProfileCard extends StatelessWidget {
  final String name;
  final String role;

  const ProfileCard({
    Key? key,
    required this.name,
    required this.role,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Container(
      width: double.infinity, // Ensure it takes maximum width
      child: Card(
        elevation: 4,
        margin: const EdgeInsets.all(8.0),
        child: Padding(
          padding: const EdgeInsets.all(16.0),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              const Text(
                'Profile Information',
                style: TextStyle(
                  fontSize: 20,
                  fontWeight: FontWeight.bold,
                ),
              ),
              const SizedBox(height: 8),
              Text(
                'Name: $name',
                style: const TextStyle(fontSize: 16),
              ),
              const SizedBox(height: 4),
              Text(
                'Role: $role',
                style: const TextStyle(fontSize: 16),
              ),
              const SizedBox(height: 16),

              // Logout Button
              Align( // Use Align to position the button
                alignment: Alignment.centerRight, // Align to the right
                child: TextButton(
                  onPressed: () {
                    // Implement logout functionality
                    Provider.of<AuthProvider>(context, listen: false).logout();
                    Navigator.of(context).pushReplacementNamed('/login'); // Adjust the route name as needed
                  },
                  child: const Text('Logout'),
                  style: TextButton.styleFrom(
                    foregroundColor: Colors.red,
                    padding: const EdgeInsets.symmetric(vertical: 12.0, horizontal: 16.0),
                    shape: RoundedRectangleBorder(
                      borderRadius: BorderRadius.circular(8.0), // Rounded corners
                    ),
                  ),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}

// DashboardCard Widget
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
      margin: const EdgeInsets.all(8.0),
      elevation: 2,
      child: InkWell(
        onTap: onTap,
        child: Padding(
          padding: const EdgeInsets.all(16.0),
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Icon(icon, size: 48, color: Colors.blue),
              const SizedBox(height: 16),
              Text(
                title,
                style: const TextStyle(
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
