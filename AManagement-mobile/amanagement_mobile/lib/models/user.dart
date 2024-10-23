class User {
  final String name;
  final String email;
  final String token;
  final int role;

  User({required this.name, required this.email, required this.token, required this.role});

  // Factory method to create a User from JSON
  factory User.fromJson(Map<String, dynamic> json) {
    return User(
      name: json['name'],
      email: json['email'],
      token: json['token'],
      role: json['role'],
    );
  }
}
