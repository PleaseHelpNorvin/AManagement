class User {
  final String token;
  final String username;

  User({required this.token, required this.username});

  factory User.fromJson(Map<String, dynamic> json) {
    return User(
      token: json['token'],
      username: json['username'],
    );
  }
}
