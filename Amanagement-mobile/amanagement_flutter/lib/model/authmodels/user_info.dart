class UserInfo {
  final int id;
  final String username;
  final String email;
  final String? emailVerifiedAt;
  final String createdAt;
  final String updatedAt;
  final int role;
  final bool isLoggedIn;
  final String? lastActiveAt;

  UserInfo({
    required this.id,
    required this.username,
    required this.email,
    this.emailVerifiedAt,
    required this.createdAt,
    required this.updatedAt,
    required this.role,
    required this.isLoggedIn,
    this.lastActiveAt,
  });

  factory UserInfo.fromJson(Map<String, dynamic> json) {
    return UserInfo(
      id: json['id'] ?? 0,
      username: json['username'] ?? '',
      email: json['email'] ?? '',
      emailVerifiedAt: json['email_verified_at'],
      createdAt: json['created_at'] ?? '',
      updatedAt: json['updated_at'] ?? '',
      role: json['role'] ?? 0, 
      isLoggedIn: json['is_logged_in'] ?? false, 
      lastActiveAt: json['last_active_at'],
    );
  }
}