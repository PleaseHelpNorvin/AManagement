import 'dart:convert';
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'package:flutter/widgets.dart'; // For Placeholder
import 'package:shared_preferences/shared_preferences.dart';
import '../screens/contract/contractlist.dart';
// import '../screens/payment/paymentlist.dart';

class HomeScreen extends StatefulWidget {
  final int userId;
  final String email;
  final String name;
  final String token;

  HomeScreen({
    required this.token,
    required this.userId,
    required this.email,
    required this.name,
  });

  @override
  _HomeScreenState createState() => _HomeScreenState();
}

class _HomeScreenState extends State<HomeScreen> {
  
  int _selectedIndex = 0;
  String? name;
  String? email;
  String? profilePictureUrl;
  bool isLoading = true;

  @override
  void initState() {
    super.initState();
    _loadProfileData();
  }

    // Clear shared preferences
  Future<void> clearSharedPreferences() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    await prefs.clear();
    print("SharedPreferences cleared.");
    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(content: Text('Logged out successfully!')),
    );
    Navigator.pushReplacementNamed(context, '/login'); // Redirect to the login screen
  }

  // Fetch profile data from the API
  Future<void> _loadProfileData() async {
    final response = await http.get(
      Uri.parse('http://127.0.0.1:8000/api/tenant/profile/${widget.userId}'),
      headers: {
        'Authorization': 'Bearer ${widget.token}',
      },
    );

    if (response.statusCode == 200) {
      final Map<String, dynamic> responseData = json.decode(response.body);
      final data = responseData['data'];

      setState(() {
        name = data['name'];
        email = data['email'];
        profilePictureUrl = data['profile_picture_url'];
        isLoading = false;
      });
    } else {
      setState(() {
        isLoading = false;
      });
      print('Failed to load profile data');
    }
  }

  // Handle BottomNavigationBar item tap
  void _onItemTapped(int index) {
    setState(() {
      _selectedIndex = index;
    });
  }

  // Handle Logout
  void _onLogout() {
    
    clearSharedPreferences();

  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        automaticallyImplyLeading: false, 
        title: const Text('Home'),
        backgroundColor: Colors.blue,
        actions: [
          IconButton(
            icon: const Icon(Icons.logout),
            onPressed: _onLogout,
          ),
        ],
      ),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          children: [
            // Profile section
            isLoading
                ? Center(child: CircularProgressIndicator())
                : Card(
                    elevation: 4,
                    shape: RoundedRectangleBorder(
                      borderRadius: BorderRadius.circular(20),
                    ),
                    child: ListTile(
                      contentPadding: EdgeInsets.symmetric(
                        vertical: 16.0,
                        horizontal: 16.0,
                      ),
                      leading: Container(
                        height: 120,
                        width: 120,
                        decoration: BoxDecoration(
                          shape: BoxShape.circle,
                          image: DecorationImage(
                            image: profilePictureUrl != null
                                ? NetworkImage(profilePictureUrl!)
                                : AssetImage('assets/profile_placeholder.png')
                                    as ImageProvider,
                            fit: BoxFit.cover,
                          ),
                        ),
                      ),
                      title: Text(
                        name ?? widget.name,
                        style: TextStyle(fontSize: 22, fontWeight: FontWeight.bold),
                      ),
                      subtitle: Text(
                        email ?? widget.email,
                        style: TextStyle(fontSize: 18),
                      ),
                      trailing: const Icon(Icons.edit),
                      onTap: () {
                        Navigator.pushNamed(context, '/editProfile');
                      },
                    ),
                  ),

            SizedBox(height: 20),

            // Grid of buttons
            Expanded(
              child: GridView.count(
                crossAxisCount: 2,
                crossAxisSpacing: 20,
                mainAxisSpacing: 20,
                children: [
                  ElevatedButton(
                    onPressed: () {
                      Navigator.push(
                        context,
                        MaterialPageRoute(
                          builder: (context) => ContractListScreen(
                            token: widget.token,
                            userId: widget.userId,
                            email: widget.email,
                            name: widget.name,
                          ),
                        ),
                      );
                    },
                    style: ElevatedButton.styleFrom(
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(12),
                      ),
                    ),
                    child: Column(
                      mainAxisAlignment: MainAxisAlignment.center,
                      children: const [
                        Icon(Icons.list, size: 40),
                        SizedBox(height: 8),
                        Text('Contracts'),
                      ],
                    ),
                  ),
                  ElevatedButton(
                    onPressed: () {
                      // Uncomment and implement PaymentListScreen when ready
                      // Navigator.push(
                      //   context,
                      //   MaterialPageRoute(
                      //     builder: (context) => PaymentListScreen(
                      //       token: widget.token,
                      //       userId: widget.userId,
                      //       email: widget.email,
                      //       name: widget.name,
                      //     ),
                      //   ),
                      // );
                    },
                    style: ElevatedButton.styleFrom(
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(12),
                      ),
                    ),
                    child: Column(
                      mainAxisAlignment: MainAxisAlignment.center,
                      children: const [
                        Icon(Icons.payment, size: 40),
                        SizedBox(height: 8),
                        Text('Payments'),
                      ],
                    ),
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
      bottomNavigationBar: BottomNavigationBar(
        currentIndex: _selectedIndex,
        onTap: _onItemTapped,
        items: const <BottomNavigationBarItem>[
          BottomNavigationBarItem(
            icon: Icon(Icons.home),
            label: 'Home',
          ),
          BottomNavigationBarItem(
            icon: Icon(Icons.notifications),
            label: 'Notifications',
          ),
        ],
      ),
    );
  }
}
