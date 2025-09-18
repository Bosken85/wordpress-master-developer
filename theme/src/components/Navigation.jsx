import { useState, useEffect } from 'react'
import { Link, useLocation } from 'react-router-dom'
import { Menu, X } from 'lucide-react'

// Import assets
import logoImg from '../assets/logo.png'

function Navigation() {
  const [isMenuOpen, setIsMenuOpen] = useState(false)
  const [isScrolled, setIsScrolled] = useState(false)
  const location = useLocation()

  useEffect(() => {
    const handleScroll = () => {
      setIsScrolled(window.scrollY > 50)
    }

    window.addEventListener('scroll', handleScroll)
    return () => window.removeEventListener('scroll', handleScroll)
  }, [])

  useEffect(() => {
    // Close mobile menu when route changes
    setIsMenuOpen(false)
    // Scroll to top when navigating to a new page
    window.scrollTo(0, 0)
  }, [location])

  // Prevent body scroll when menu is open
  useEffect(() => {
    if (isMenuOpen) {
      document.body.style.overflow = 'hidden'
    } else {
      document.body.style.overflow = 'unset'
    }
    
    // Cleanup on unmount
    return () => {
      document.body.style.overflow = 'unset'
    }
  }, [isMenuOpen])

  const toggleMenu = () => {
    setIsMenuOpen(!isMenuOpen)
  }

  const navLinks = [
    { to: '/', label: 'Home' },
    { to: '/about', label: 'About Us' },
    { to: '/services', label: 'Services' },
    { to: '/contact', label: 'Contact' }
  ]

  return (
    <>
      {/* TrueHorizon.ai Style Navigation */}
      <nav className={`fixed top-0 left-0 right-0 z-50 transition-all duration-300 ${
        isScrolled ? 'bg-white shadow-lg' : 'bg-white/95 backdrop-blur-sm'
      }`}>
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="flex items-center justify-between h-16">
            {/* Logo - Left Side */}
            <div className="flex-shrink-0">
              <Link to="/" className="flex items-center">
                <img 
                  src={logoImg} 
                  alt="WordPress Master Developer" 
                  className="h-10 w-auto"
                />
              </Link>
            </div>

            {/* Desktop Navigation - Center/Right */}
            <div className="hidden md:block">
              <div className="ml-10 flex items-baseline space-x-8">
                {navLinks.map((link, index) => (
                  <Link
                    key={index}
                    to={link.to}
                    className={`px-3 py-2 text-sm font-medium transition-colors duration-200 hover:text-orange-500 ${
                      location.pathname === link.to
                        ? 'text-orange-500 font-semibold'
                        : 'text-gray-700'
                    }`}
                  >
                    {link.label}
                  </Link>
                ))}
              </div>
            </div>

            {/* CTA Button - Right Side (Desktop) */}
            <div className="hidden md:block">
              <Link to="/contact">
                <button className="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                  Get Started
                </button>
              </Link>
            </div>

            {/* Mobile menu button */}
            <div className="md:hidden">
              <button
                onClick={toggleMenu}
                className="inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-orange-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-orange-500 transition-colors duration-200"
                aria-expanded={isMenuOpen}
                aria-label="Toggle navigation menu"
              >
                {isMenuOpen ? (
                  <X className="block h-6 w-6" aria-hidden="true" />
                ) : (
                  <Menu className="block h-6 w-6" aria-hidden="true" />
                )}
              </button>
            </div>
          </div>
        </div>
      </nav>

      {/* Full-Screen Mobile Menu Overlay */}
      <div className={`fixed inset-0 z-40 md:hidden transition-opacity duration-300 ${
        isMenuOpen ? 'opacity-100 pointer-events-auto' : 'opacity-0 pointer-events-none'
      }`}>
        {/* Background Overlay */}
        <div 
          className="absolute inset-0 bg-black bg-opacity-50 transition-opacity duration-300"
          onClick={() => setIsMenuOpen(false)}
        />
        
        {/* Full-Screen Menu Panel - Slides in from Right */}
        <div className={`absolute top-0 right-0 h-full w-full bg-white shadow-xl transform transition-transform duration-300 ease-in-out ${
          isMenuOpen ? 'translate-x-0' : 'translate-x-full'
        }`}>
          {/* Menu Header */}
          <div className="flex items-center justify-between p-4 border-b border-gray-200">
            <Link to="/" onClick={() => setIsMenuOpen(false)}>
              <img 
                src={logoImg} 
                alt="WordPress Master Developer" 
                className="h-8 w-auto"
              />
            </Link>
            <button
              onClick={() => setIsMenuOpen(false)}
              className="p-2 rounded-md text-gray-700 hover:text-orange-500 hover:bg-gray-100 transition-colors duration-200"
              aria-label="Close menu"
            >
              <X className="h-6 w-6" />
            </button>
          </div>

          {/* Menu Content */}
          <div className="flex flex-col h-full pt-8 pb-6 px-6">
            {/* Navigation Links */}
            <nav className="flex-1">
              <div className="space-y-6">
                {navLinks.map((link, index) => (
                  <Link
                    key={index}
                    to={link.to}
                    className={`block text-2xl font-medium transition-colors duration-200 hover:text-orange-500 ${
                      location.pathname === link.to
                        ? 'text-orange-500 font-semibold'
                        : 'text-gray-900'
                    }`}
                    onClick={() => setIsMenuOpen(false)}
                  >
                    {link.label}
                  </Link>
                ))}
              </div>
            </nav>

            {/* Mobile CTA Button */}
            <div className="mt-8">
              <Link to="/contact" onClick={() => setIsMenuOpen(false)}>
                <button className="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-4 rounded-md text-lg font-medium transition-colors duration-200">
                  Get Started
                </button>
              </Link>
            </div>

            {/* Additional Menu Footer (Optional) */}
            <div className="mt-8 pt-6 border-t border-gray-200">
              <p className="text-sm text-gray-500 text-center">
                © 2025 WordPress Master Developer
              </p>
            </div>
          </div>
        </div>
      </div>

      {/* Spacer to prevent content from hiding behind fixed nav */}
      <div className="h-16"></div>
    </>
  )
}

export default Navigation
