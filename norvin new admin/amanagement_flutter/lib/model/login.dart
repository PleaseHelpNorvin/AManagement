class LoginResponse {
  final bool success;
  final String message;
  final String? token;
  final Map<String, dynamic>? user;
  final bool isAuthenticated;

  LoginResponse({
    required this.success,
    required this.message,
    this.token,
    this.user,
    required this.isAuthenticated,
  });

  factory LoginResponse.fromJson(Map<String, dynamic> json) {
    return LoginResponse(
      success: json['success'],
      message: json['data']['message'], // Access 'data' directly as an object
      token: json['data']['token'],
      user: json['data']['user'], // The user is already nested inside 'data'
      isAuthenticated: json['data']['is_authenticated'] ?? false,
    );
  }
}
