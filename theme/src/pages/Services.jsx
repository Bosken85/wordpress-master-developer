import { useState } from 'react'
import { motion } from 'framer-motion'
import { Button } from '@/components/ui/button.jsx'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card.jsx'
import { Badge } from '@/components/ui/badge.jsx'
import { 
  Code, 
  Wrench, 
  Zap, 
  Shield, 
  Palette, 
  Database, 
  Globe, 
  Smartphone,
  Search,
  ShoppingCart,
  Settings,
  FileText,
  ArrowRight,
  CheckCircle
} from 'lucide-react'
import { Link } from 'react-router-dom'

function Services() {
  const [activeService, setActiveService] = useState(0)

  const mainServices = [
    {
      icon: <Code className="w-8 h-8" />,
      title: "Custom Theme Development",
      description: "Creating fully responsive, high-performance WordPress themes built to modern standards. Every theme is crafted with clean code, SEO optimization, and cross-device compatibility.",
      features: [
        "Responsive design for all devices",
        "SEO-optimized code structure",
        "Cross-browser compatibility",
        "Custom post types and fields",
        "Theme customizer integration",
        "Performance optimization"
      ],
      price: "Starting at $2,500"
    },
    {
      icon: <Wrench className="w-8 h-8" />,
      title: "Plugin Integration & Customization",
      description: "Expert integration of popular WordPress plugins with custom functionality. Specializing in WooCommerce, Advanced Custom Fields, and form builders.",
      features: [
        "WooCommerce integration",
        "Advanced Custom Fields setup",
        "Contact Form 7 customization",
        "Custom plugin development",
        "Third-party API integration",
        "Plugin conflict resolution"
      ],
      price: "Starting at $800"
    },
    {
      icon: <Zap className="w-8 h-8" />,
      title: "Performance Optimization",
      description: "Implementing best practices for speed, security, and scalability. Proper script and style enqueuing, database optimization, and caching strategies.",
      features: [
        "Page speed optimization",
        "Database query optimization",
        "Caching implementation",
        "Image optimization",
        "Code minification",
        "CDN setup and configuration"
      ],
      price: "Starting at $1,200"
    },
    {
      icon: <Shield className="w-8 h-8" />,
      title: "Installation Wizard Development",
      description: "Custom installation wizards with automatic plugin installation, demo content import, and initial setup configuration using TGM Plugin Activation library.",
      features: [
        "Automatic plugin installation",
        "Demo content import",
        "Theme setup wizard",
        "Configuration automation",
        "User-friendly interface",
        "Error handling and validation"
      ],
      price: "Starting at $1,500"
    }
  ]

  const additionalServices = [
    {
      icon: <Palette className="w-6 h-6" />,
      title: "Theme Customization",
      description: "Modify existing themes to match your brand and requirements.",
      price: "$500 - $1,500"
    },
    {
      icon: <Database className="w-6 h-6" />,
      title: "Database Migration",
      description: "Safe and secure WordPress site migrations and database transfers.",
      price: "$300 - $800"
    },
    {
      icon: <Globe className="w-6 h-6" />,
      title: "Multisite Setup",
      description: "WordPress multisite network configuration and management.",
      price: "$800 - $2,000"
    },
    {
      icon: <Smartphone className="w-6 h-6" />,
      title: "Mobile Optimization",
      description: "Ensure your WordPress site performs perfectly on mobile devices.",
      price: "$600 - $1,200"
    },
    {
      icon: <Search className="w-6 h-6" />,
      title: "SEO Implementation",
      description: "Technical SEO optimization for better search engine rankings.",
      price: "$400 - $1,000"
    },
    {
      icon: <ShoppingCart className="w-6 h-6" />,
      title: "E-commerce Solutions",
      description: "Complete WooCommerce store setup and customization.",
      price: "$1,500 - $5,000"
    },
    {
      icon: <Settings className="w-6 h-6" />,
      title: "Maintenance & Support",
      description: "Ongoing WordPress maintenance, updates, and technical support.",
      price: "$200 - $500/month"
    },
    {
      icon: <FileText className="w-6 h-6" />,
      title: "Documentation",
      description: "Comprehensive theme documentation and user guides.",
      price: "$300 - $800"
    }
  ]

  const packages = [
    {
      name: "Starter Package",
      price: "$2,500",
      description: "Perfect for small businesses and personal websites",
      features: [
        "Custom WordPress theme",
        "Responsive design",
        "Basic SEO optimization",
        "Contact form integration",
        "Social media integration",
        "30 days support"
      ],
      popular: false
    },
    {
      name: "Professional Package",
      price: "$4,500",
      description: "Ideal for growing businesses and e-commerce sites",
      features: [
        "Custom WordPress theme",
        "WooCommerce integration",
        "Advanced Custom Fields",
        "Performance optimization",
        "Installation wizard",
        "Plugin customization",
        "60 days support"
      ],
      popular: true
    },
    {
      name: "Enterprise Package",
      price: "$8,000",
      description: "Complete solution for large businesses and agencies",
      features: [
        "Custom WordPress theme",
        "Multisite setup",
        "Advanced integrations",
        "Custom plugin development",
        "Performance optimization",
        "Security hardening",
        "Training and documentation",
        "90 days support"
      ],
      popular: false
    }
  ]

  const process = [
    {
      step: "1",
      title: "Discovery & Planning",
      description: "Understanding your requirements, goals, and technical specifications."
    },
    {
      step: "2",
      title: "Design & Prototyping",
      description: "Creating wireframes and prototypes for your approval."
    },
    {
      step: "3",
      title: "Development",
      description: "Building your custom WordPress solution with clean, optimized code."
    },
    {
      step: "4",
      title: "Testing & Launch",
      description: "Thorough testing and deployment to your live environment."
    },
    {
      step: "5",
      title: "Support & Maintenance",
      description: "Ongoing support and maintenance to keep your site running smoothly."
    }
  ]

  return (
    <div className="min-h-screen bg-background pt-20">
      {/* Hero Section */}
      <section className="py-20 bg-muted/30">
        <div className="container mx-auto px-4">
          <motion.div
            initial={{ opacity: 0, y: 30 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.8 }}
            className="text-center mb-16"
          >
            <h1 className="text-5xl md:text-6xl font-bold mb-6">WordPress Development Services</h1>
            <p className="text-xl text-muted-foreground max-w-4xl mx-auto">
              Comprehensive WordPress solutions from custom theme development to performance optimization. 
              Everything you need to create exceptional WordPress websites.
            </p>
          </motion.div>
        </div>
      </section>

      {/* Main Services Section */}
      <section className="py-20">
        <div className="container mx-auto px-4">
          <motion.div
            initial={{ opacity: 0, y: 30 }}
            whileInView={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6 }}
            viewport={{ once: true }}
            className="text-center mb-16"
          >
            <h2 className="text-4xl font-bold mb-6">Core Services</h2>
            <p className="text-lg text-muted-foreground max-w-3xl mx-auto">
              Our primary WordPress development services designed to meet your specific needs.
            </p>
          </motion.div>

          <div className="grid lg:grid-cols-2 gap-8">
            {mainServices.map((service, index) => (
              <motion.div
                key={index}
                initial={{ opacity: 0, y: 30 }}
                whileInView={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.6, delay: index * 0.1 }}
                viewport={{ once: true }}
              >
                <Card 
                  className="h-full hover:shadow-lg transition-all duration-300 cursor-pointer border-2 hover:border-orange-500/50"
                  onMouseEnter={() => setActiveService(index)}
                >
                  <CardHeader>
                    <div className="flex items-start justify-between mb-4">
                      <div className="w-16 h-16 bg-orange-500/10 rounded-lg flex items-center justify-center text-orange-500">
                        {service.icon}
                      </div>
                      <Badge variant="secondary" className="text-orange-600 bg-orange-100">
                        {service.price}
                      </Badge>
                    </div>
                    <CardTitle className="text-2xl mb-2">{service.title}</CardTitle>
                    <CardDescription className="text-base">
                      {service.description}
                    </CardDescription>
                  </CardHeader>
                  <CardContent>
                    <div className="space-y-3">
                      {service.features.map((feature, featureIndex) => (
                        <div key={featureIndex} className="flex items-center space-x-3">
                          <CheckCircle className="w-4 h-4 text-green-500 flex-shrink-0" />
                          <span className="text-sm text-muted-foreground">{feature}</span>
                        </div>
                      ))}
                    </div>
                  </CardContent>
                </Card>
              </motion.div>
            ))}
          </div>
        </div>
      </section>

      {/* Additional Services Section */}
      <section className="py-20 bg-muted/30">
        <div className="container mx-auto px-4">
          <motion.div
            initial={{ opacity: 0, y: 30 }}
            whileInView={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6 }}
            viewport={{ once: true }}
            className="text-center mb-16"
          >
            <h2 className="text-4xl font-bold mb-6">Additional Services</h2>
            <p className="text-lg text-muted-foreground max-w-3xl mx-auto">
              Complementary services to enhance and maintain your WordPress website.
            </p>
          </motion.div>

          <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            {additionalServices.map((service, index) => (
              <motion.div
                key={index}
                initial={{ opacity: 0, y: 30 }}
                whileInView={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.6, delay: index * 0.1 }}
                viewport={{ once: true }}
              >
                <Card className="h-full hover:shadow-lg transition-all duration-300">
                  <CardHeader>
                    <div className="w-12 h-12 bg-orange-500/10 rounded-lg flex items-center justify-center mb-4 text-orange-500">
                      {service.icon}
                    </div>
                    <CardTitle className="text-lg">{service.title}</CardTitle>
                  </CardHeader>
                  <CardContent>
                    <CardDescription className="text-sm mb-4">
                      {service.description}
                    </CardDescription>
                    <Badge variant="outline" className="text-orange-600 border-orange-200">
                      {service.price}
                    </Badge>
                  </CardContent>
                </Card>
              </motion.div>
            ))}
          </div>
        </div>
      </section>

      {/* Packages Section */}
      <section className="py-20">
        <div className="container mx-auto px-4">
          <motion.div
            initial={{ opacity: 0, y: 30 }}
            whileInView={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6 }}
            viewport={{ once: true }}
            className="text-center mb-16"
          >
            <h2 className="text-4xl font-bold mb-6">Service Packages</h2>
            <p className="text-lg text-muted-foreground max-w-3xl mx-auto">
              Choose the package that best fits your project requirements and budget.
            </p>
          </motion.div>

          <div className="grid md:grid-cols-3 gap-8">
            {packages.map((pkg, index) => (
              <motion.div
                key={index}
                initial={{ opacity: 0, y: 30 }}
                whileInView={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.6, delay: index * 0.1 }}
                viewport={{ once: true }}
              >
                <Card className={`h-full relative ${pkg.popular ? 'border-orange-500 border-2' : ''}`}>
                  {pkg.popular && (
                    <div className="absolute -top-3 left-1/2 transform -translate-x-1/2">
                      <Badge className="bg-orange-500 text-white">Most Popular</Badge>
                    </div>
                  )}
                  <CardHeader className="text-center">
                    <CardTitle className="text-2xl mb-2">{pkg.name}</CardTitle>
                    <div className="text-4xl font-bold text-orange-500 mb-2">{pkg.price}</div>
                    <CardDescription>{pkg.description}</CardDescription>
                  </CardHeader>
                  <CardContent>
                    <div className="space-y-3 mb-6">
                      {pkg.features.map((feature, featureIndex) => (
                        <div key={featureIndex} className="flex items-center space-x-3">
                          <CheckCircle className="w-4 h-4 text-green-500 flex-shrink-0" />
                          <span className="text-sm">{feature}</span>
                        </div>
                      ))}
                    </div>
                    <Link to="/contact">
                      <Button 
                        className={`w-full ${pkg.popular ? 'bg-orange-500 hover:bg-orange-600 text-white' : 'bg-muted hover:bg-muted/80'}`}
                      >
                        Get Started
                      </Button>
                    </Link>
                  </CardContent>
                </Card>
              </motion.div>
            ))}
          </div>
        </div>
      </section>

      {/* Process Section */}
      <section className="py-20 bg-muted/30">
        <div className="container mx-auto px-4">
          <motion.div
            initial={{ opacity: 0, y: 30 }}
            whileInView={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6 }}
            viewport={{ once: true }}
            className="text-center mb-16"
          >
            <h2 className="text-4xl font-bold mb-6">Our Development Process</h2>
            <p className="text-lg text-muted-foreground max-w-3xl mx-auto">
              A proven methodology that ensures quality, transparency, and client satisfaction at every step.
            </p>
          </motion.div>

          <div className="grid md:grid-cols-5 gap-8">
            {process.map((step, index) => (
              <motion.div
                key={index}
                initial={{ opacity: 0, y: 30 }}
                whileInView={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.6, delay: index * 0.1 }}
                viewport={{ once: true }}
                className="text-center"
              >
                <div className="w-16 h-16 bg-orange-500 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-6">
                  {step.step}
                </div>
                <h3 className="text-xl font-semibold mb-4">{step.title}</h3>
                <p className="text-muted-foreground text-sm">{step.description}</p>
              </motion.div>
            ))}
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="py-20">
        <div className="container mx-auto px-4">
          <motion.div
            initial={{ opacity: 0, y: 30 }}
            whileInView={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6 }}
            viewport={{ once: true }}
            className="text-center"
          >
            <h2 className="text-4xl font-bold mb-6">Ready to Start Your WordPress Project?</h2>
            <p className="text-lg text-muted-foreground max-w-3xl mx-auto mb-8">
              Let's discuss your requirements and create a custom WordPress solution that exceeds your expectations.
            </p>
            <div className="flex flex-col sm:flex-row gap-4 justify-center">
              <Link to="/about">
                <Button variant="outline" className="border-orange-500 text-orange-500 hover:bg-orange-500 hover:text-white">
                  Learn More About Us
                </Button>
              </Link>
              <Link to="/contact">
                <Button className="bg-orange-500 hover:bg-orange-600 text-white">
                  Get Free Quote <ArrowRight className="ml-2 w-4 h-4" />
                </Button>
              </Link>
            </div>
          </motion.div>
        </div>
      </section>
    </div>
  )
}

export default Services
