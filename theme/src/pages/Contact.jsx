import { useState } from 'react'
import { motion } from 'framer-motion'
import { Button } from '@/components/ui/button.jsx'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card.jsx'
import { Input } from '@/components/ui/input.jsx'
import { Textarea } from '@/components/ui/textarea.jsx'
import { Label } from '@/components/ui/label.jsx'
import { 
  Mail, 
  Phone, 
  MapPin, 
  Clock, 
  MessageSquare, 
  Send,
  CheckCircle,
  Globe,
  Calendar,
  DollarSign
} from 'lucide-react'

function Contact() {
  const [formData, setFormData] = useState({
    name: '',
    email: '',
    phone: '',
    company: '',
    projectType: '',
    budget: '',
    timeline: '',
    message: ''
  })

  const [isSubmitted, setIsSubmitted] = useState(false)

  const handleInputChange = (e) => {
    const { name, value } = e.target
    setFormData(prev => ({
      ...prev,
      [name]: value
    }))
  }

  const handleSubmit = (e) => {
    e.preventDefault()
    // Here you would typically send the form data to your backend
    console.log('Form submitted:', formData)
    setIsSubmitted(true)
    
    // Reset form after 3 seconds
    setTimeout(() => {
      setIsSubmitted(false)
      setFormData({
        name: '',
        email: '',
        phone: '',
        company: '',
        projectType: '',
        budget: '',
        timeline: '',
        message: ''
      })
    }, 3000)
  }

  const contactInfo = [
    {
      icon: <Mail className="w-6 h-6" />,
      title: "Email",
      value: "contact@wpmaster.dev",
      description: "Send us an email anytime"
    },
    {
      icon: <Phone className="w-6 h-6" />,
      title: "Phone",
      value: "+1 (555) 123-4567",
      description: "Mon-Fri from 8am to 6pm EST"
    },
    {
      icon: <MapPin className="w-6 h-6" />,
      title: "Location",
      value: "Available Worldwide",
      description: "Remote WordPress development services"
    },
    {
      icon: <Clock className="w-6 h-6" />,
      title: "Response Time",
      value: "Within 24 Hours",
      description: "We'll get back to you quickly"
    }
  ]

  const projectTypes = [
    "Custom WordPress Theme",
    "Plugin Development",
    "Website Redesign",
    "Performance Optimization",
    "E-commerce Solution",
    "Maintenance & Support",
    "Other"
  ]

  const budgetRanges = [
    "Under $2,500",
    "$2,500 - $5,000",
    "$5,000 - $10,000",
    "$10,000 - $25,000",
    "$25,000+"
  ]

  const timelines = [
    "ASAP (Rush Job)",
    "1-2 weeks",
    "3-4 weeks",
    "1-2 months",
    "3+ months",
    "Flexible"
  ]

  const faqs = [
    {
      question: "How long does a typical WordPress project take?",
      answer: "Project timelines vary based on complexity. A custom theme typically takes 2-4 weeks, while more complex projects with custom functionality may take 6-8 weeks."
    },
    {
      question: "Do you provide ongoing maintenance and support?",
      answer: "Yes, we offer comprehensive maintenance packages including updates, security monitoring, backups, and technical support starting at $200/month."
    },
    {
      question: "Can you work with existing WordPress sites?",
      answer: "Absolutely! We can enhance, optimize, or completely redesign existing WordPress websites while preserving your content and SEO rankings."
    },
    {
      question: "What's included in your WordPress development service?",
      answer: "Our services include custom theme development, responsive design, SEO optimization, performance tuning, security implementation, and comprehensive testing."
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
            <h1 className="text-5xl md:text-6xl font-bold mb-6">Get In Touch</h1>
            <p className="text-xl text-muted-foreground max-w-4xl mx-auto">
              Ready to start your WordPress project? Let's discuss your requirements and create something amazing together.
            </p>
          </motion.div>
        </div>
      </section>

      {/* Contact Info Section */}
      <section className="py-20">
        <div className="container mx-auto px-4">
          <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-8 mb-20">
            {contactInfo.map((info, index) => (
              <motion.div
                key={index}
                initial={{ opacity: 0, y: 30 }}
                whileInView={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.6, delay: index * 0.1 }}
                viewport={{ once: true }}
                className="text-center"
              >
                <div className="w-16 h-16 bg-orange-500/10 rounded-lg flex items-center justify-center mx-auto mb-6 text-orange-500">
                  {info.icon}
                </div>
                <h3 className="text-xl font-semibold mb-2">{info.title}</h3>
                <p className="text-lg font-medium text-orange-500 mb-2">{info.value}</p>
                <p className="text-sm text-muted-foreground">{info.description}</p>
              </motion.div>
            ))}
          </div>
        </div>
      </section>

      {/* Contact Form Section */}
      <section className="py-20 bg-muted/30">
        <div className="container mx-auto px-4">
          <div className="grid lg:grid-cols-2 gap-12">
            {/* Contact Form */}
            <motion.div
              initial={{ opacity: 0, x: -30 }}
              whileInView={{ opacity: 1, x: 0 }}
              transition={{ duration: 0.6 }}
              viewport={{ once: true }}
            >
              <Card>
                <CardHeader>
                  <CardTitle className="text-2xl flex items-center">
                    <MessageSquare className="w-6 h-6 mr-2 text-orange-500" />
                    Start Your Project
                  </CardTitle>
                  <CardDescription>
                    Fill out the form below and we'll get back to you within 24 hours with a detailed proposal.
                  </CardDescription>
                </CardHeader>
                <CardContent>
                  {isSubmitted ? (
                    <motion.div
                      initial={{ opacity: 0, scale: 0.9 }}
                      animate={{ opacity: 1, scale: 1 }}
                      className="text-center py-8"
                    >
                      <CheckCircle className="w-16 h-16 text-green-500 mx-auto mb-4" />
                      <h3 className="text-2xl font-semibold mb-2">Thank You!</h3>
                      <p className="text-muted-foreground">
                        Your message has been sent successfully. We'll get back to you within 24 hours.
                      </p>
                    </motion.div>
                  ) : (
                    <form onSubmit={handleSubmit} className="space-y-6">
                      <div className="grid md:grid-cols-2 gap-4">
                        <div>
                          <Label htmlFor="name">Full Name *</Label>
                          <Input
                            id="name"
                            name="name"
                            value={formData.name}
                            onChange={handleInputChange}
                            required
                            placeholder="John Doe"
                          />
                        </div>
                        <div>
                          <Label htmlFor="email">Email Address *</Label>
                          <Input
                            id="email"
                            name="email"
                            type="email"
                            value={formData.email}
                            onChange={handleInputChange}
                            required
                            placeholder="john@example.com"
                          />
                        </div>
                      </div>

                      <div className="grid md:grid-cols-2 gap-4">
                        <div>
                          <Label htmlFor="phone">Phone Number</Label>
                          <Input
                            id="phone"
                            name="phone"
                            value={formData.phone}
                            onChange={handleInputChange}
                            placeholder="+1 (555) 123-4567"
                          />
                        </div>
                        <div>
                          <Label htmlFor="company">Company/Organization</Label>
                          <Input
                            id="company"
                            name="company"
                            value={formData.company}
                            onChange={handleInputChange}
                            placeholder="Your Company"
                          />
                        </div>
                      </div>

                      <div>
                        <Label htmlFor="projectType">Project Type *</Label>
                        <select
                          id="projectType"
                          name="projectType"
                          value={formData.projectType}
                          onChange={handleInputChange}
                          required
                          className="w-full p-2 border border-input rounded-md bg-background"
                        >
                          <option value="">Select project type</option>
                          {projectTypes.map((type, index) => (
                            <option key={index} value={type}>{type}</option>
                          ))}
                        </select>
                      </div>

                      <div className="grid md:grid-cols-2 gap-4">
                        <div>
                          <Label htmlFor="budget">Budget Range</Label>
                          <select
                            id="budget"
                            name="budget"
                            value={formData.budget}
                            onChange={handleInputChange}
                            className="w-full p-2 border border-input rounded-md bg-background"
                          >
                            <option value="">Select budget range</option>
                            {budgetRanges.map((range, index) => (
                              <option key={index} value={range}>{range}</option>
                            ))}
                          </select>
                        </div>
                        <div>
                          <Label htmlFor="timeline">Timeline</Label>
                          <select
                            id="timeline"
                            name="timeline"
                            value={formData.timeline}
                            onChange={handleInputChange}
                            className="w-full p-2 border border-input rounded-md bg-background"
                          >
                            <option value="">Select timeline</option>
                            {timelines.map((timeline, index) => (
                              <option key={index} value={timeline}>{timeline}</option>
                            ))}
                          </select>
                        </div>
                      </div>

                      <div>
                        <Label htmlFor="message">Project Description *</Label>
                        <Textarea
                          id="message"
                          name="message"
                          value={formData.message}
                          onChange={handleInputChange}
                          required
                          rows={5}
                          placeholder="Please describe your project requirements, goals, and any specific features you need..."
                        />
                      </div>

                      <Button type="submit" className="w-full bg-orange-500 hover:bg-orange-600 text-white">
                        Send Message <Send className="ml-2 w-4 h-4" />
                      </Button>
                    </form>
                  )}
                </CardContent>
              </Card>
            </motion.div>

            {/* Additional Info */}
            <motion.div
              initial={{ opacity: 0, x: 30 }}
              whileInView={{ opacity: 1, x: 0 }}
              transition={{ duration: 0.6 }}
              viewport={{ once: true }}
              className="space-y-8"
            >
              {/* Why Choose Us */}
              <Card>
                <CardHeader>
                  <CardTitle className="text-xl">Why Choose WordPress Master Developer?</CardTitle>
                </CardHeader>
                <CardContent className="space-y-4">
                  <div className="flex items-start space-x-3">
                    <CheckCircle className="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" />
                    <div>
                      <h4 className="font-semibold">Expert WordPress Development</h4>
                      <p className="text-sm text-muted-foreground">Deep expertise in WordPress core, themes, and plugins</p>
                    </div>
                  </div>
                  <div className="flex items-start space-x-3">
                    <CheckCircle className="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" />
                    <div>
                      <h4 className="font-semibold">Performance Optimized</h4>
                      <p className="text-sm text-muted-foreground">Fast-loading, SEO-friendly websites that rank well</p>
                    </div>
                  </div>
                  <div className="flex items-start space-x-3">
                    <CheckCircle className="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" />
                    <div>
                      <h4 className="font-semibold">Responsive Design</h4>
                      <p className="text-sm text-muted-foreground">Mobile-first approach ensuring perfect display on all devices</p>
                    </div>
                  </div>
                  <div className="flex items-start space-x-3">
                    <CheckCircle className="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" />
                    <div>
                      <h4 className="font-semibold">Ongoing Support</h4>
                      <p className="text-sm text-muted-foreground">Comprehensive maintenance and support packages available</p>
                    </div>
                  </div>
                </CardContent>
              </Card>

              {/* Quick Stats */}
              <Card>
                <CardHeader>
                  <CardTitle className="text-xl">Project Statistics</CardTitle>
                </CardHeader>
                <CardContent>
                  <div className="grid grid-cols-2 gap-4">
                    <div className="text-center">
                      <div className="text-3xl font-bold text-orange-500">500+</div>
                      <div className="text-sm text-muted-foreground">Themes Developed</div>
                    </div>
                    <div className="text-center">
                      <div className="text-3xl font-bold text-orange-500">200+</div>
                      <div className="text-sm text-muted-foreground">Happy Clients</div>
                    </div>
                    <div className="text-center">
                      <div className="text-3xl font-bold text-orange-500">99.9%</div>
                      <div className="text-sm text-muted-foreground">Uptime</div>
                    </div>
                    <div className="text-center">
                      <div className="text-3xl font-bold text-orange-500">&lt;2s</div>
                      <div className="text-sm text-muted-foreground">Load Time</div>
                    </div>
                  </div>
                </CardContent>
              </Card>

              {/* Service Icons */}
              <Card>
                <CardHeader>
                  <CardTitle className="text-xl">What We Offer</CardTitle>
                </CardHeader>
                <CardContent>
                  <div className="grid grid-cols-3 gap-4">
                    <div className="text-center">
                      <Globe className="w-8 h-8 text-orange-500 mx-auto mb-2" />
                      <div className="text-sm">Custom Themes</div>
                    </div>
                    <div className="text-center">
                      <DollarSign className="w-8 h-8 text-orange-500 mx-auto mb-2" />
                      <div className="text-sm">E-commerce</div>
                    </div>
                    <div className="text-center">
                      <Calendar className="w-8 h-8 text-orange-500 mx-auto mb-2" />
                      <div className="text-sm">Maintenance</div>
                    </div>
                  </div>
                </CardContent>
              </Card>
            </motion.div>
          </div>
        </div>
      </section>

      {/* FAQ Section */}
      <section className="py-20">
        <div className="container mx-auto px-4">
          <motion.div
            initial={{ opacity: 0, y: 30 }}
            whileInView={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6 }}
            viewport={{ once: true }}
            className="text-center mb-16"
          >
            <h2 className="text-4xl font-bold mb-6">Frequently Asked Questions</h2>
            <p className="text-lg text-muted-foreground max-w-3xl mx-auto">
              Common questions about our WordPress development services.
            </p>
          </motion.div>

          <div className="grid md:grid-cols-2 gap-8 max-w-6xl mx-auto">
            {faqs.map((faq, index) => (
              <motion.div
                key={index}
                initial={{ opacity: 0, y: 30 }}
                whileInView={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.6, delay: index * 0.1 }}
                viewport={{ once: true }}
              >
                <Card>
                  <CardHeader>
                    <CardTitle className="text-lg">{faq.question}</CardTitle>
                  </CardHeader>
                  <CardContent>
                    <CardDescription className="text-base">
                      {faq.answer}
                    </CardDescription>
                  </CardContent>
                </Card>
              </motion.div>
            ))}
          </div>
        </div>
      </section>
    </div>
  )
}

export default Contact
