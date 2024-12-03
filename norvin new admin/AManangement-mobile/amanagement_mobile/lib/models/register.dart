class RegisterResponse {
  final bool success;
  final String message;
  final String? token;
  final Map<String, dynamic>? user;
  final bool isAuthenticated;

  RegisterResponse({
    required this.success,
    required this.message,
    this.token,
    this.user,
    required this.isAuthenticated,
  });

  factory RegisterResponse.fromJson(Map<String, dynamic> json) {
    return RegisterResponse(
      success: json['success'],
      message: json['data']?['message'],
      token: json['data']?['token'],
      user: json['data']?['user'],
      isAuthenticated: json['data']?['is_authenticated'] ?? false,
    );
  }
}

