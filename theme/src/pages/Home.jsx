import { useState } from 'react'
import { Button } from '@/components/ui/button.jsx'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card.jsx'
import { Badge } from '@/components/ui/badge.jsx'
import { Code, Palette, Zap, Shield, Wrench, CheckCircle, ArrowRight } from 'lucide-react'
import { motion } from 'framer-motion'
import { Link } from 'react-router-dom'

// Import assets
import heroBgImg from '../assets/hero-bg.png'
import workspaceImg from '../assets/workspace.jpg'

function Home() {
  const [activeService, setActiveService] = useState(0)

  const services = [
    {
      icon: <Code className="w-8 h-8" />,
      title: "Custom Theme Development",
      description: "Creating fully responsive, high-performance WordPress themes built to modern standards."
    },
    {
      icon: <Wrench className="w-8 h-8" />,
      title: "Plugin Integration & Customization",
      description: "Expert integration of popular WordPress plugins with custom functionality."
    },
    {
      icon: <Zap className="w-8 h-8" />,
      title: "Performance Optimization",
      description: "Implementing best practices for speed, security, and scalability."
    },
    {
      icon: <Shield className="w-8 h-8" />,
      title: "Installation Wizard Development",
      description: "Custom installation wizards with automatic plugin installation and demo content import."
    }
  ]

  const expertise = [
    "Custom WordPress theme development from scratch",
    "Popular plugins integration (WooCommerce, ACF, Contact Form 7)",
    "Major theme builders compatibility (Elementor, Divi, Beaver Builder)",
    "WordPress template hierarchy mastery",
    "Theme Customizer implementation",
    "Hooks and filters expertise",
    "Performance and security optimization"
  ]

  const process = [
    {
      step: "1",
      title: "Prototyping Phase",
      description: "HTML/CSS/JS prototyping for rapid, interactive design development and browser testing."
    },
    {
      step: "2", 
      title: "WordPress Integration",
      description: "Converting prototypes into fully functional WordPress themes with proper template hierarchy implementation."
    },
    {
      step: "3",
      title: "Testing & Optimization", 
      description: "Comprehensive testing across devices and browsers, performance optimization, and security hardening."
    },
    {
      step: "4",
      title: "Deployment Package",
      description: "Complete WordPress theme package with proper file structure, documentation, and installation wizard."
    }
  ]

  return (
    <div className="min-h-screen bg-background">
      {/* Hero Section */}
      <section className="relative min-h-screen flex items-center justify-center overflow-hidden">
        <div 
          className="absolute inset-0 bg-cover bg-center bg-no-repeat"
          style={{ backgroundImage: `url(${heroBgImg})` }}
        >
          <div className="absolute inset-0 bg-black/60"></div>
        </div>
        <div className="relative z-10 container mx-auto px-4 text-center text-white">
          <motion.div
            initial={{ opacity: 0, y: 30 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.8 }}
          >
            <h1 className="text-5xl md:text-7xl font-bold mb-6">
              WordPress Master Developer
            </h1>
            <p className="text-xl md:text-2xl mb-8 max-w-3xl mx-auto text-gray-200">
              Expert AI assistant specializing in custom WordPress theme development from scratch
            </p>
            <p className="text-lg mb-12 max-w-4xl mx-auto text-gray-300">
              Deep expertise in PHP, CSS, HTML, and JavaScript. Creating high-quality, performance-optimized WordPress themes that are fully integrated with WordPress core and built for security, scalability, and upgrade safety.
            </p>
            <Link to="/contact">
              <Button size="lg" className="bg-orange-500 hover:bg-orange-600 text-white text-lg px-8 py-4">
                Start Your Project <ArrowRight className="ml-2 w-5 h-5" />
              </Button>
            </Link>
          </motion.div>
        </div>
      </section>

      {/* About Section Preview */}
      <section className="py-20 bg-muted/30">
        <div className="container mx-auto px-4">
          <div className="grid md:grid-cols-2 gap-12 items-center">
            <motion.div
              initial={{ opacity: 0, x: -30 }}
              whileInView={{ opacity: 1, x: 0 }}
              transition={{ duration: 0.6 }}
              viewport={{ once: true }}
            >
              <h2 className="text-4xl font-bold mb-6">Your WordPress Development Expert</h2>
              <p className="text-lg text-muted-foreground mb-8">
                I am a WordPress Master Developer with comprehensive expertise in both management and development of WordPress websites. My deep understanding of PHP, CSS, HTML, and JavaScript, combined with extensive knowledge of web development principles, allows me to create exceptional WordPress solutions.
              </p>
              <div className="space-y-4 mb-8">
                {expertise.slice(0, 4).map((item, index) => (
                  <motion.div
                    key={index}
                    initial={{ opacity: 0, x: -20 }}
                    whileInView={{ opacity: 1, x: 0 }}
                    transition={{ duration: 0.4, delay: index * 0.1 }}
                    viewport={{ once: true }}
                    className="flex items-center space-x-3"
                  >
                    <CheckCircle className="w-5 h-5 text-green-500 flex-shrink-0" />
                    <span className="text-foreground">{item}</span>
                  </motion.div>
                ))}
              </div>
              <Link to="/about">
                <Button variant="outline" className="border-orange-500 text-orange-500 hover:bg-orange-500 hover:text-white">
                  Learn More About Us
                </Button>
              </Link>
            </motion.div>
            <motion.div
              initial={{ opacity: 0, x: 30 }}
              whileInView={{ opacity: 1, x: 0 }}
              transition={{ duration: 0.6 }}
              viewport={{ once: true }}
              className="relative"
            >
              <img 
                src={workspaceImg} 
                alt="Professional WordPress Development" 
                className="rounded-lg shadow-2xl"
              />
              <div className="absolute inset-0 bg-gradient-to-tr from-orange-500/20 to-transparent rounded-lg"></div>
            </motion.div>
          </div>
        </div>
      </section>

      {/* Services Section Preview */}
      <section className="py-20">
        <div className="container mx-auto px-4">
          <motion.div
            initial={{ opacity: 0, y: 30 }}
            whileInView={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6 }}
            viewport={{ once: true }}
            className="text-center mb-16"
          >
            <h2 className="text-4xl font-bold mb-6">Comprehensive WordPress Development Services</h2>
            <p className="text-lg text-muted-foreground max-w-3xl mx-auto">
              From custom theme development to performance optimization, I provide end-to-end WordPress solutions that exceed expectations.
            </p>
          </motion.div>

          <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
            {services.map((service, index) => (
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
                    <div className="w-16 h-16 bg-orange-500/10 rounded-lg flex items-center justify-center mb-4 text-orange-500">
                      {service.icon}
                    </div>
                    <CardTitle className="text-xl">{service.title}</CardTitle>
                  </CardHeader>
                  <CardContent>
                    <CardDescription className="text-base">
                      {service.description}
                    </CardDescription>
                  </CardContent>
                </Card>
              </motion.div>
            ))}
          </div>

          <div className="text-center">
            <Link to="/services">
              <Button className="bg-orange-500 hover:bg-orange-600 text-white">
                View All Services <ArrowRight className="ml-2 w-4 h-4" />
              </Button>
            </Link>
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
            <h2 className="text-4xl font-bold mb-6">Development Workflow</h2>
            <p className="text-lg text-muted-foreground max-w-3xl mx-auto">
              A proven process that ensures quality, performance, and client satisfaction at every step.
            </p>
          </motion.div>

          <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
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
                <p className="text-muted-foreground">{step.description}</p>
              </motion.div>
            ))}
          </div>
        </div>
      </section>

      {/* Portfolio Section */}
      <section className="py-20">
        <div className="container mx-auto px-4">
          <motion.div
            initial={{ opacity: 0, y: 30 }}
            whileInView={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6 }}
            viewport={{ once: true }}
            className="text-center mb-16"
          >
            <h2 className="text-4xl font-bold mb-6">Featured WordPress Projects</h2>
            <p className="text-lg text-muted-foreground max-w-3xl mx-auto">
              Showcasing excellence in WordPress theme development across various industries and use cases.
            </p>
          </motion.div>

          <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            {['Custom E-commerce Themes', 'Business Portfolio Sites', 'Blog & Magazine Layouts', 'Agency & Corporate Websites'].map((project, index) => (
              <motion.div
                key={index}
                initial={{ opacity: 0, scale: 0.9 }}
                whileInView={{ opacity: 1, scale: 1 }}
                transition={{ duration: 0.6, delay: index * 0.1 }}
                viewport={{ once: true }}
              >
                <Card className="hover:shadow-lg transition-all duration-300">
                  <CardHeader>
                    <div className="w-full h-32 bg-gradient-to-br from-orange-500/20 to-blue-500/20 rounded-lg mb-4 flex items-center justify-center">
                      <Palette className="w-12 h-12 text-orange-500" />
                    </div>
                    <CardTitle className="text-lg">{project}</CardTitle>
                  </CardHeader>
                  <CardContent>
                    <Badge variant="secondary" className="mb-2">WordPress</Badge>
                    <p className="text-sm text-muted-foreground">
                      Professional theme development with modern design and optimal performance.
                    </p>
                  </CardContent>
                </Card>
              </motion.div>
            ))}
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="py-20 bg-muted/30">
        <div className="container mx-auto px-4">
          <motion.div
            initial={{ opacity: 0, y: 30 }}
            whileInView={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6 }}
            viewport={{ once: true }}
            className="text-center"
          >
            <h2 className="text-4xl font-bold mb-6">Ready to Build Your WordPress Theme?</h2>
            <p className="text-lg text-muted-foreground max-w-3xl mx-auto mb-8">
              Let's discuss your project requirements and create a custom WordPress solution that exceeds your expectations.
            </p>
            <Link to="/contact">
              <Button size="lg" className="bg-orange-500 hover:bg-orange-600 text-white text-lg px-8 py-4">
                Get Started Today <ArrowRight className="ml-2 w-5 h-5" />
              </Button>
            </Link>
          </motion.div>
        </div>
      </section>
    </div>
  )
}

export default Home
