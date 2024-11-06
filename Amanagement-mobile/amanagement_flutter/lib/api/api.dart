class Api {
  static const String baseUrl = 'http://127.0.0.1:8000/api';
  static const String loginEndpoint = '$baseUrl/tenant-login';
  static const String registerEndpoint = '$baseUrl/tenant-register';
  static const String tenantInfoUpdateEndpoint = '$baseUrl/client-info';
  static const String logoutEndpoint = '$baseUrl/logout';
}