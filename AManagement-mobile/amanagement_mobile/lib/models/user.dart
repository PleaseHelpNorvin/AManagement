class User {
  final String token;
  final String role;
  final bool isLoggedIn;

  User({required this.token, required this.role, required this.isLoggedIn});

  // Factory method to create a User from JSON
  factory User.fromJson(Map<String, dynamic> json) {
    return User(
      token: json['token'],
      role: json['role'],
      isLoggedIn: json['is_logged_in'], // Changed to match your API response
    );
  }
}
