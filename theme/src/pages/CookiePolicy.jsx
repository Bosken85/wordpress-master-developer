import { motion } from 'framer-motion'
import { Cookie, Settings, BarChart, Shield, Eye, Trash2 } from 'lucide-react'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card.jsx'
import { Badge } from '@/components/ui/badge.jsx'

function CookiePolicy() {
  const lastUpdated = "September 18, 2025"

  const cookieTypes = [
    {
      icon: <Settings className="w-6 h-6" />,
      title: "Essential Cookies",
      badge: "Required",
      badgeVariant: "destructive",
      description: "Necessary for basic website functionality and security",
      examples: [
        "Session management and user authentication",
        "Security tokens and CSRF protection",
        "Load balancing and server routing",
        "Basic website functionality and navigation"
      ],
      canDisable: false
    },
    {
      icon: <BarChart className="w-6 h-6" />,
      title: "Analytics Cookies",
      badge: "Optional",
      badgeVariant: "secondary",
      description: "Help us understand how visitors interact with our website",
      examples: [
        "Google Analytics for traffic analysis",
        "Page view tracking and user behavior",
        "Performance monitoring and optimization",
        "A/B testing and conversion tracking"
      ],
      canDisable: true
    },
    {
      icon: <Eye className="w-6 h-6" />,
      title: "Functional Cookies",
      badge: "Optional",
      badgeVariant: "secondary",
      description: "Enhance your experience with personalized features",
      examples: [
        "Language and region preferences",
        "Theme and display settings",
        "Form data and user preferences",
        "Chat widget and support features"
      ],
      canDisable: true
    },
    {
      icon: <Shield className="w-6 h-6" />,
      title: "Marketing Cookies",
      badge: "Optional",
      badgeVariant: "secondary",
      description: "Used to deliver relevant content and track campaign effectiveness",
      examples: [
        "Social media integration and sharing",
        "Advertising campaign tracking",
        "Retargeting and remarketing pixels",
        "Third-party marketing platforms"
      ],
      canDisable: true
    }
  ]

  const cookieTable = [
    {
      name: "_ga",
      purpose: "Google Analytics - Distinguishes unique users",
      duration: "2 years",
      type: "Analytics"
    },
    {
      name: "_gid",
      purpose: "Google Analytics - Distinguishes unique users",
      duration: "24 hours",
      type: "Analytics"
    },
    {
      name: "session_id",
      purpose: "Maintains user session state",
      duration: "Session",
      type: "Essential"
    },
    {
      name: "csrf_token",
      purpose: "Security protection against CSRF attacks",
      duration: "Session",
      type: "Essential"
    },
    {
      name: "preferences",
      purpose: "Stores user preferences and settings",
      duration: "1 year",
      type: "Functional"
    }
  ]

  return (
    <div className="min-h-screen bg-background">
      {/* Hero Section */}
      <section className="py-20 bg-muted/30">
        <div className="container mx-auto px-4">
          <motion.div
            initial={{ opacity: 0, y: 30 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.8 }}
            className="text-center mb-16"
          >
            <div className="w-16 h-16 bg-orange-500/10 rounded-lg flex items-center justify-center mx-auto mb-6 text-orange-500">
              <Cookie className="w-8 h-8" />
            </div>
            <h1 className="text-5xl md:text-6xl font-bold mb-6">Cookie Policy</h1>
            <p className="text-xl text-muted-foreground max-w-4xl mx-auto">
              Learn about how we use cookies and similar technologies to enhance your browsing experience and improve our services.
            </p>
            <p className="text-sm text-muted-foreground mt-4">
              Last updated: {lastUpdated}
            </p>
          </motion.div>
        </div>
      </section>

      {/* Introduction */}
      <section className="py-16">
        <div className="container mx-auto px-4 max-w-4xl">
          <motion.div
            initial={{ opacity: 0, y: 30 }}
            whileInView={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6 }}
            viewport={{ once: true }}
            className="prose prose-lg max-w-none"
          >
            <h2 className="text-3xl font-bold mb-6">What Are Cookies?</h2>
            <p className="text-lg leading-relaxed mb-6">
              Cookies are small text files that are stored on your device (computer, tablet, or mobile) when you visit our website. They help us provide you with a better browsing experience by remembering your preferences, analyzing how you use our site, and enabling certain functionality.
            </p>
            <p className="text-lg leading-relaxed mb-8">
              This Cookie Policy explains what cookies we use, why we use them, and how you can manage your cookie preferences. By continuing to use our website, you consent to our use of cookies as described in this policy.
            </p>
          </motion.div>
        </div>
      </section>

      {/* Cookie Types */}
      <section className="py-16 bg-muted/30">
        <div className="container mx-auto px-4">
          <motion.div
            initial={{ opacity: 0, y: 30 }}
            whileInView={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6 }}
            viewport={{ once: true }}
            className="text-center mb-12"
          >
            <h2 className="text-3xl font-bold mb-6">Types of Cookies We Use</h2>
            <p className="text-lg text-muted-foreground max-w-3xl mx-auto">
              We use different types of cookies for various purposes to enhance your experience
            </p>
          </motion.div>

          <div className="grid md:grid-cols-2 gap-8 max-w-6xl mx-auto">
            {cookieTypes.map((type, index) => (
              <motion.div
                key={index}
                initial={{ opacity: 0, y: 30 }}
                whileInView={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.6, delay: index * 0.1 }}
                viewport={{ once: true }}
              >
                <Card className="h-full">
                  <CardHeader>
                    <div className="flex items-center justify-between mb-4">
                      <div className="w-12 h-12 bg-orange-500/10 rounded-lg flex items-center justify-center text-orange-500">
                        {type.icon}
                      </div>
                      <Badge variant={type.badgeVariant}>{type.badge}</Badge>
                    </div>
                    <CardTitle className="text-xl">{type.title}</CardTitle>
                    <CardDescription className="text-base">
                      {type.description}
                    </CardDescription>
                  </CardHeader>
                  <CardContent>
                    <div className="space-y-3">
                      <h4 className="font-semibold text-sm">Examples:</h4>
                      <ul className="space-y-2">
                        {type.examples.map((example, exampleIndex) => (
                          <li key={exampleIndex} className="flex items-start space-x-2 text-sm text-muted-foreground">
                            <div className="w-1.5 h-1.5 bg-orange-500 rounded-full mt-2 flex-shrink-0"></div>
                            <span>{example}</span>
                          </li>
                        ))}
                      </ul>
                      <div className="pt-3 border-t">
                        <span className={`text-sm font-medium ${type.canDisable ? 'text-green-600' : 'text-red-600'}`}>
                          {type.canDisable ? '✓ Can be disabled' : '✗ Cannot be disabled'}
                        </span>
                      </div>
                    </div>
                  </CardContent>
                </Card>
              </motion.div>
            ))}
          </div>
        </div>
      </section>

      {/* Cookie Details Table */}
      <section className="py-16">
        <div className="container mx-auto px-4 max-w-6xl">
          <motion.div
            initial={{ opacity: 0, y: 30 }}
            whileInView={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6 }}
            viewport={{ once: true }}
            className="mb-12"
          >
            <h2 className="text-3xl font-bold mb-6">Specific Cookies We Use</h2>
            <p className="text-lg text-muted-foreground mb-8">
              Below is a detailed list of the specific cookies used on our website
            </p>
          </motion.div>

          <motion.div
            initial={{ opacity: 0, y: 30 }}
            whileInView={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6 }}
            viewport={{ once: true }}
            className="overflow-x-auto"
          >
            <table className="w-full border-collapse bg-card rounded-lg overflow-hidden shadow-sm">
              <thead>
                <tr className="bg-muted">
                  <th className="text-left p-4 font-semibold">Cookie Name</th>
                  <th className="text-left p-4 font-semibold">Purpose</th>
                  <th className="text-left p-4 font-semibold">Duration</th>
                  <th className="text-left p-4 font-semibold">Type</th>
                </tr>
              </thead>
              <tbody>
                {cookieTable.map((cookie, index) => (
                  <tr key={index} className="border-t border-border">
                    <td className="p-4 font-mono text-sm">{cookie.name}</td>
                    <td className="p-4 text-sm">{cookie.purpose}</td>
                    <td className="p-4 text-sm">{cookie.duration}</td>
                    <td className="p-4">
                      <Badge 
                        variant={cookie.type === 'Essential' ? 'destructive' : 'secondary'}
                        className="text-xs"
                      >
                        {cookie.type}
                      </Badge>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </motion.div>
        </div>
      </section>

      {/* Third-Party Cookies */}
      <section className="py-16 bg-muted/30">
        <div className="container mx-auto px-4 max-w-4xl">
          <motion.div
            initial={{ opacity: 0, y: 30 }}
            whileInView={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6 }}
            viewport={{ once: true }}
          >
            <h2 className="text-3xl font-bold mb-6">Third-Party Cookies</h2>
            <div className="prose prose-lg max-w-none">
              <p className="mb-6">
                Some cookies on our website are set by third-party services that we use to enhance functionality and analyze performance:
              </p>
              
              <div className="grid md:grid-cols-2 gap-6 mb-8">
                <div className="bg-card p-6 rounded-lg">
                  <h3 className="text-xl font-semibold mb-3">Google Analytics</h3>
                  <p className="text-muted-foreground mb-3">
                    Helps us understand how visitors interact with our website through anonymous data collection.
                  </p>
                  <a 
                    href="https://policies.google.com/privacy" 
                    target="_blank" 
                    rel="noopener noreferrer"
                    className="text-orange-500 hover:underline text-sm"
                  >
                    Google Privacy Policy →
                  </a>
                </div>
                
                <div className="bg-card p-6 rounded-lg">
                  <h3 className="text-xl font-semibold mb-3">Social Media Platforms</h3>
                  <p className="text-muted-foreground mb-3">
                    Enable social sharing features and may track interactions for their own analytics.
                  </p>
                  <p className="text-sm text-muted-foreground">
                    Includes Facebook, Twitter, LinkedIn
                  </p>
                </div>
              </div>
              
              <p>
                These third-party services have their own privacy policies and cookie practices. We recommend reviewing their policies to understand how they handle your data.
              </p>
            </div>
          </motion.div>
        </div>
      </section>

      {/* Managing Cookies */}
      <section className="py-16">
        <div className="container mx-auto px-4 max-w-4xl">
          <motion.div
            initial={{ opacity: 0, y: 30 }}
            whileInView={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6 }}
            viewport={{ once: true }}
          >
            <h2 className="text-3xl font-bold mb-6">Managing Your Cookie Preferences</h2>
            <div className="prose prose-lg max-w-none">
              <p className="mb-6">
                You have several options for managing cookies on our website:
              </p>
              
              <div className="grid md:grid-cols-3 gap-6 mb-8">
                <Card>
                  <CardHeader>
                    <Settings className="w-8 h-8 text-orange-500 mb-2" />
                    <CardTitle className="text-lg">Browser Settings</CardTitle>
                  </CardHeader>
                  <CardContent>
                    <p className="text-sm text-muted-foreground">
                      Configure cookie preferences directly in your browser settings to block or allow specific types of cookies.
                    </p>
                  </CardContent>
                </Card>
                
                <Card>
                  <CardHeader>
                    <Eye className="w-8 h-8 text-orange-500 mb-2" />
                    <CardTitle className="text-lg">Cookie Banner</CardTitle>
                  </CardHeader>
                  <CardContent>
                    <p className="text-sm text-muted-foreground">
                      Use our cookie consent banner to accept or reject optional cookies when you first visit our website.
                    </p>
                  </CardContent>
                </Card>
                
                <Card>
                  <CardHeader>
                    <Trash2 className="w-8 h-8 text-orange-500 mb-2" />
                    <CardTitle className="text-lg">Clear Cookies</CardTitle>
                  </CardHeader>
                  <CardContent>
                    <p className="text-sm text-muted-foreground">
                      Delete existing cookies from your browser to reset your preferences and start fresh.
                    </p>
                  </CardContent>
                </Card>
              </div>
              
              <h3 className="text-2xl font-semibold mb-4">Browser-Specific Instructions</h3>
              <ul className="list-disc pl-6 space-y-2 mb-6">
                <li><strong>Chrome:</strong> Settings → Privacy and security → Cookies and other site data</li>
                <li><strong>Firefox:</strong> Settings → Privacy & Security → Cookies and Site Data</li>
                <li><strong>Safari:</strong> Preferences → Privacy → Manage Website Data</li>
                <li><strong>Edge:</strong> Settings → Cookies and site permissions → Cookies and site data</li>
              </ul>
              
              <div className="bg-orange-500/10 border border-orange-500/20 rounded-lg p-6">
                <h4 className="font-semibold mb-2">⚠️ Important Note</h4>
                <p className="text-sm">
                  Disabling certain cookies may affect website functionality. Essential cookies cannot be disabled as they are necessary for basic website operation and security.
                </p>
              </div>
            </div>
          </motion.div>
        </div>
      </section>

      {/* Updates and Contact */}
      <section className="py-16 bg-muted/30">
        <div className="container mx-auto px-4 max-w-4xl">
          <div className="grid md:grid-cols-2 gap-8">
            <motion.div
              initial={{ opacity: 0, y: 30 }}
              whileInView={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.6 }}
              viewport={{ once: true }}
            >
              <h2 className="text-2xl font-bold mb-4">Updates to This Policy</h2>
              <p className="text-muted-foreground mb-4">
                We may update this Cookie Policy from time to time to reflect changes in our practices or applicable laws. We will notify you of any material changes by posting the updated policy on our website.
              </p>
              <p className="text-sm text-muted-foreground">
                Check the "Last updated" date at the top of this page to see when the policy was last revised.
              </p>
            </motion.div>
            
            <motion.div
              initial={{ opacity: 0, y: 30 }}
              whileInView={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.6, delay: 0.1 }}
              viewport={{ once: true }}
            >
              <h2 className="text-2xl font-bold mb-4">Questions or Concerns?</h2>
              <p className="text-muted-foreground mb-4">
                If you have any questions about our use of cookies or this Cookie Policy, please don't hesitate to contact us.
              </p>
              <div className="space-y-2 text-sm">
                <div className="flex items-center space-x-2">
                  <span>📧</span>
                  <span>contact@wpmaster.dev</span>
                </div>
                <div className="flex items-center space-x-2">
                  <span>📞</span>
                  <span>+1 (555) 123-4567</span>
                </div>
              </div>
            </motion.div>
          </div>
        </div>
      </section>
    </div>
  )
}

export default CookiePolicy
