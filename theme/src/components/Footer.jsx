import { Link } from 'react-router-dom'
import { Mail, Phone, MapPin, Globe, Github, Linkedin, Twitter } from 'lucide-react'

// Import assets
import logoImg from '../assets/logo.png'

function Footer() {
  const currentYear = new Date().getFullYear()

  const footerLinks = {
    services: [
      { to: '/services', label: 'Custom Theme Development' },
      { to: '/services', label: 'Plugin Integration' },
      { to: '/services', label: 'Performance Optimization' },
      { to: '/services', label: 'Maintenance & Support' }
    ],
    company: [
      { to: '/about', label: 'About Us' },
      { to: '/services', label: 'Services' },
      { to: '/contact', label: 'Contact' },
      { to: '#', label: 'Portfolio' }
    ],
    legal: [
      { to: '/privacy-policy', label: 'Privacy Policy' },
      { to: '/terms-of-service', label: 'Terms of Service' },
      { to: '/cookie-policy', label: 'Cookie Policy' },
      { to: '/disclaimer', label: 'Disclaimer' }
    ]
  }

  const contactInfo = [
    {
      icon: <Mail className="w-4 h-4" />,
      text: 'contact@wpmaster.dev'
    },
    {
      icon: <Phone className="w-4 h-4" />,
      text: '+1 (555) 123-4567'
    },
    {
      icon: <MapPin className="w-4 h-4" />,
      text: 'Available Worldwide'
    }
  ]

  const socialLinks = [
    {
      icon: <Github className="w-5 h-5" />,
      href: '#',
      label: 'GitHub'
    },
    {
      icon: <Linkedin className="w-5 h-5" />,
      href: '#',
      label: 'LinkedIn'
    },
    {
      icon: <Twitter className="w-5 h-5" />,
      href: '#',
      label: 'Twitter'
    },
    {
      icon: <Globe className="w-5 h-5" />,
      href: '#',
      label: 'Website'
    }
  ]

  return (
    <footer className="bg-gray-900 text-white">
      {/* Main Footer Content */}
      <div className="container mx-auto px-4 py-16">
        <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
          {/* Company Info */}
          <div className="lg:col-span-1">
            <div className="flex items-center space-x-2 mb-6">
              <img src={logoImg} alt="WordPress Master Developer" className="h-10" />
            </div>
            <p className="text-gray-300 mb-6 text-sm leading-relaxed">
              Expert WordPress Master Developer specializing in custom theme development, 
              plugin integration, and performance optimization. Creating exceptional WordPress 
              solutions that exceed expectations.
            </p>
            
            {/* Contact Info */}
            <div className="space-y-3">
              {contactInfo.map((info, index) => (
                <div key={index} className="flex items-center space-x-3 text-sm text-gray-300">
                  <div className="text-orange-500">
                    {info.icon}
                  </div>
                  <span>{info.text}</span>
                </div>
              ))}
            </div>
          </div>

          {/* Services Links */}
          <div>
            <h3 className="text-lg font-semibold mb-6 text-orange-500">Services</h3>
            <ul className="space-y-3">
              {footerLinks.services.map((link, index) => (
                <li key={index}>
                  <Link
                    to={link.to}
                    className="text-gray-300 hover:text-orange-500 transition-colors duration-200 text-sm"
                  >
                    {link.label}
                  </Link>
                </li>
              ))}
            </ul>
          </div>

          {/* Company Links */}
          <div>
            <h3 className="text-lg font-semibold mb-6 text-orange-500">Company</h3>
            <ul className="space-y-3">
              {footerLinks.company.map((link, index) => (
                <li key={index}>
                  <Link
                    to={link.to}
                    className="text-gray-300 hover:text-orange-500 transition-colors duration-200 text-sm"
                  >
                    {link.label}
                  </Link>
                </li>
              ))}
            </ul>
          </div>

          {/* Legal & Newsletter */}
          <div>
            <h3 className="text-lg font-semibold mb-6 text-orange-500">Legal</h3>
            <ul className="space-y-3 mb-6">
              {footerLinks.legal.map((link, index) => (
                <li key={index}>
                  <Link
                    to={link.to}
                    className="text-gray-300 hover:text-orange-500 transition-colors duration-200 text-sm"
                  >
                    {link.label}
                  </Link>
                </li>
              ))}
            </ul>

            {/* Social Links */}
            <div>
              <h4 className="text-sm font-semibold mb-3 text-gray-200">Follow Us</h4>
              <div className="flex space-x-3">
                {socialLinks.map((social, index) => (
                  <a
                    key={index}
                    href={social.href}
                    aria-label={social.label}
                    className="w-8 h-8 bg-gray-800 rounded-full flex items-center justify-center text-gray-300 hover:bg-orange-500 hover:text-white transition-all duration-200"
                  >
                    {social.icon}
                  </a>
                ))}
              </div>
            </div>
          </div>
        </div>
      </div>

      {/* Bottom Footer */}
      <div className="border-t border-gray-800">
        <div className="container mx-auto px-4 py-6">
          <div className="flex flex-col md:flex-row items-center justify-between">
            <div className="text-sm text-gray-400 mb-4 md:mb-0">
              © {currentYear} WordPress Master Developer. All rights reserved.
            </div>
            
            <div className="flex items-center space-x-6 text-sm text-gray-400">
              <span>Built with ❤️ using WordPress expertise</span>
              <div className="flex items-center space-x-2">
                <div className="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                <span>Available for projects</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      {/* Back to Top Button */}
      <button
        onClick={() => window.scrollTo({ top: 0, behavior: 'smooth' })}
        className="fixed bottom-6 right-6 w-12 h-12 bg-orange-500 hover:bg-orange-600 text-white rounded-full shadow-lg transition-all duration-200 flex items-center justify-center z-50"
        aria-label="Back to top"
      >
        <svg
          className="w-5 h-5"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            strokeLinecap="round"
            strokeLinejoin="round"
            strokeWidth={2}
            d="M5 10l7-7m0 0l7 7m-7-7v18"
          />
        </svg>
      </button>
    </footer>
  )
}

export default Footer
